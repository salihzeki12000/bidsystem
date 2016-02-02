<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Company;
use App\CompanyFeature;
use App\CountryStateTown;
use App\Industry;
use App\Job;
use App\Rating;
use App\Requirement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function exportReport(Request $request){
        //dd($request->all());
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $report_type = $request->report_type;
        $export_type = $request->export_type;
        $company_id = $request->company_id;

        switch($report_type){
            case "1":
                return $this->jobManagement($start_date, $end_date, $export_type, $company_id);
                break;
            case "2":
                return $this->jobPerformance($start_date, $end_date, $export_type, $company_id);
                break;
            case "3":
                return $this->compareBudget($start_date, $end_date, $export_type, $company_id);
                break;
            case "4":
                return $this->outsourceDistribution($start_date, $end_date, $export_type, $company_id);
                break;
            case "5":
                return $this->targetManagement($start_date, $end_date, $export_type, $company_id);
                break;
            case "6":
                return $this->bidPerformance($start_date, $end_date, $export_type, $company_id);
                break;
            case "7":
                return $this->positioningPerformance($start_date, $end_date, $export_type, $company_id);
                break;
            case "8":
                return $this->ratingPerformance($start_date, $end_date, $export_type, $company_id);
                break;
            case "9":
                return $this->outsourcingTrend($start_date, $end_date, $export_type, $company_id);
                break;
            case "10":
                return $this->lspDistribution($start_date, $end_date, $export_type, $company_id);
                break;
        }
    }

    //report 1
    public function jobManagement($start_date, $end_date, $export_type, $company_id){

        if(\Auth::user()->company_id){
            $company_id = \Auth::user()->company_id;
        }

        $job_order = "1,4,6,5";

        $jobs = Job::with('rfi_status')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('company_id', '=', $company_id)
            ->orderByRaw(DB::raw("FIELD(status_id, $job_order)"))
            ->get();

        $count_draft = 0;
        $count_published = 0;
        $count_canceled = 0;
        $count_awarded = 0;
        if(count($jobs) > 0){
            foreach($jobs as $job){
                switch ($job->status_id) {
                    case 1:
                        $count_draft++;
                        break;
                    case 4:
                        $count_published++;
                        break;
                    case 5:
                        $count_canceled++;
                        break;
                    case 6:
                        $count_awarded++;
                        break;
                }
            }
        }

        if($export_type == 'report'){
            return view('report.report_1', compact('jobs', 'count_draft', 'count_published', 'count_canceled', 'count_awarded'));
        }else{
            Excel::create('Job Management Report', function($excel) use ($jobs, $count_draft, $count_published, $count_canceled, $count_awarded) {

                $excel->sheet('New sheet', function($sheet) use ($jobs, $count_draft, $count_published, $count_canceled, $count_awarded) {

                    $sheet->loadView('report.report_1', array('jobs' => $jobs, 'count_draft' => $count_draft, 'count_published' => $count_published, 'count_canceled' => $count_canceled, 'count_awarded' => $count_awarded));

                });

            })->export('csv');
        }
    }

    //report 2
    public function jobPerformance($start_date, $end_date, $export_type, $company_id){
        $start_date = new Carbon($start_date);
        $end_date = new Carbon($end_date);
        $days = $end_date->diffInDays($start_date);

        if(\Auth::user()->company_id){
            $company_id = \Auth::user()->company_id;
        }

        $jobs = Job::with('company')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('company_id', $company_id)->get();
        $total_valid_bids_received = 0;

        if($days > 0){
            foreach($jobs as $job_key => $job){
                $total_valid_bids_posted = $job->valid_bids()->count();
                $total_valid_bids_received+=$total_valid_bids_posted;
                $performance = round($total_valid_bids_posted / $days, 3);
                $jobs[$job_key]['performance'] = $performance;
                $jobs[$job_key]['number_of_days'] = $days;
                $jobs[$job_key]['total_bids'] = $total_valid_bids_posted;
            }
        }

        if($export_type == 'report'){
            return view('report.report_2', compact('jobs', 'total_valid_bids_received'));
        }else{
            Excel::create('Job Performance Report', function($excel) use ($jobs, $total_valid_bids_received) {

                $excel->sheet('New sheet', function($sheet) use ($jobs, $total_valid_bids_received) {

                    $sheet->loadView('report.report_2', array('jobs' => $jobs, 'total_valid_bids_received' => $total_valid_bids_received));

                });

            })->export('csv');
        }
    }


    //report 3
    public function compareBudget($start_date, $end_date, $export_type, $company_id){
        if(\Auth::user()->company_id){
            $company_id = \Auth::user()->company_id;
        }
        $jobs = Job::with('valid_bids')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('company_id', $company_id)->get();

        foreach($jobs as $job_key => $job){
            $count_higher_price = 0;
            $count_lower_price = 0;
            $count_equal_price = 0;
            if(count($job->valid_bids) > 0){
                foreach($job->valid_bids as $bid){
                    if($bid->est_budget > $job->existing_budget){
                        $count_higher_price++;
                    }elseif($bid->est_budget < $job->existing_budget){
                        $count_lower_price++;
                    }else{
                        $count_equal_price++;
                    }
                }
            }
            $jobs[$job_key]['exceed_budget'] = $count_higher_price;
            $jobs[$job_key]['below_budget'] = $count_lower_price;
            $jobs[$job_key]['equal_budget'] = $count_equal_price;
        }

        if($export_type == 'report'){
            return view('report.report_3', compact('jobs'));
        }else{
            Excel::create('Positioning Management Report', function($excel) use ($jobs) {

                $excel->sheet('New sheet', function($sheet) use ($jobs) {

                    $sheet->loadView('report.report_3', array('jobs' => $jobs));

                });

            })->export('csv');
        }
    }

    //report 4
    public function outsourceDistribution($start_date, $end_date, $export_type, $company_id){
        if(\Auth::user()->company_id){
            $company_id = \Auth::user()->company_id;
        }

        $requirements = Requirement::with(array('jobs' => function($query) use ($start_date, $end_date)
        {
            $query->where('jobs.created_at', '>=', $start_date)->where('jobs.created_at', '<=', $end_date);
        }))->get();

        foreach($requirements as $requirement_key => $requirement){
            $total_jobs = count($requirement->jobs);
            $total_jobs_post_by_current_company = 0;
            $percentage = 0;
            if($total_jobs > 0){
                foreach($requirement->jobs as $job){
                    if($job->company_id == $company_id){
                        $total_jobs_post_by_current_company++;
                    }
                }
                if($total_jobs != 0){
                    $percentage = $total_jobs_post_by_current_company/$total_jobs * 100;
                }
            }
            $requirements[$requirement_key]['total_jobs'] = $total_jobs;
            $requirements[$requirement_key]['total_jobs_post_by_current_company'] = $total_jobs_post_by_current_company;
            $requirements[$requirement_key]['percentage'] = $percentage;
        }

        if($export_type == 'report'){
            return view('report.report_4', compact('requirements'));
        }else{
            Excel::create('Potential Overview Report', function($excel) use ($requirements) {

                $excel->sheet('New sheet', function($sheet) use ($requirements) {

                    $sheet->loadView('report.report_4', array('requirements' => $requirements));

                });

            })->export('csv');
        }
    }

    //report 5
    public function targetManagement($start_date, $end_date, $export_type, $company_id){

        if(\Auth::user()->company_id){
            $company_id = \Auth::user()->company_id;
        }

        $bids = Bid::where('company_id', '=', $company_id)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();
        $count_sales = 0;
        $count_open_bids = 0;

        if(count($bids) > 0){
            foreach($bids as $bid){
                if($bid->status_id == 6){
                    $count_sales++;
                }else if(in_array($bid->status_id, [7, 8, 9])){
                    $count_open_bids++;
                }
            }
        }

        if($export_type == 'report'){
            return view('report.report_5', compact('bids', 'count_sales', 'count_open_bids'));
        }else{
            Excel::create('Target Management Report', function($excel) use ($bids, $count_sales, $count_open_bids) {

                $excel->sheet('New sheet', function($sheet) use ($bids, $count_sales, $count_open_bids) {

                    $sheet->loadView('report.report_5', array('bids' => $bids, 'count_sales' => $count_sales, 'count_open_bids' => $count_open_bids));

                });

            })->export('csv');
        }
    }


    //report 6
    public function bidPerformance($start_date, $end_date, $export_type, $company_id){

        if(\Auth::user()->company_id){
            $company_id = \Auth::user()->company_id;
        }

        $bids = Bid::where('company_id', '=', $company_id)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();
        $count_success = 0;
        $count_failure = 0;

        if(count($bids) > 0){
            foreach($bids as $bid){
                if(in_array($bid->status_id, [10])){
                    $count_failure++;
                }elseif(in_array($bid->status_id, [6])){
                    $count_success++;
                }
            }
        }

        if($export_type == 'report'){
            return view('report.report_6', compact('bids', 'count_success', 'count_failure'));
        }else{
            Excel::create('Bid Performance Report', function($excel) use ($bids, $count_success, $count_failure) {

                $excel->sheet('New sheet', function($sheet) use ($bids, $count_success, $count_failure) {

                    $sheet->loadView('report.report_6', array('bids' => $bids, 'count_success' => $count_success, 'count_failure' => $count_failure));

                });

            })->export('csv');
        }
    }

    //report 7
    public function positioningPerformance($start_date, $end_date, $export_type, $company_id){

        if(\Auth::user()->company_id){
            $company_id = \Auth::user()->company_id;
        }

        $bids_group_by_industry = Industry::leftJoin('company_industry', 'company_industry.industry_id', '=', 'industries.id')
            ->leftJoin('bids', function($join) use ($start_date, $end_date, $company_id)
            {
                $join->on('bids.company_id', '=', 'company_industry.company_id')
                    ->where('bids.created_at', '>=', $start_date)
                    ->where('bids.created_at', '<=', $end_date)
                    ->where('bids.company_id', '=', $company_id)
                    ->whereIn('bids.status_id', [6, 10]);
            })
            ->select(\DB::raw('count(bids.id) as count, industries.id, industries.industry, bids.status_id'))
            ->groupBy('industries.industry', 'bids.status_id')
            ->get();

        $refined_bids_group_by_industry_array = array();
        if(count($bids_group_by_industry) > 0){
            foreach($bids_group_by_industry as $bid_key => $bid){
                if(!array_key_exists($bid->id, $refined_bids_group_by_industry_array)){
                    $refined_bids_group_by_industry_array[$bid->id]['success'] = 0;
                    $refined_bids_group_by_industry_array[$bid->id]['failure'] = 0;
                    $refined_bids_group_by_industry_array[$bid->id]['other'] = 0;
                }
                //echo $bid->status_id;
                if($bid->status_id == '6'){
                    $refined_bids_group_by_industry_array[$bid->id]['success'] = $bid->count;
                    $refined_bids_group_by_industry_array[$bid->id]['industry'] = $bid->industry;
                }else if($bid->status_id == '10'){
                    $refined_bids_group_by_industry_array[$bid->id]['failure'] = $bid->count;
                    $refined_bids_group_by_industry_array[$bid->id]['industry'] = $bid->industry;
                }else{
                    $refined_bids_group_by_industry_array[$bid->id]['other'] = $bid->count;
                    $refined_bids_group_by_industry_array[$bid->id]['industry'] = $bid->industry;
                }
            }
        }

        $bids_group_by_location = CountryStateTown::leftJoin('jobs', 'jobs.location_id', '=', 'country_state_towns.id')
            ->leftJoin('bids', function($join) use ($start_date, $end_date, $company_id)
            {
                $join->on('bids.job_id', '=', 'jobs.id')
                    ->where('bids.created_at', '>=', $start_date)
                    ->where('bids.created_at', '<=', $end_date)
                    ->where('bids.company_id', '=', $company_id)
                    ->whereIn('bids.status_id', [6, 10]);
            })
            ->select(\DB::raw('count(bids.id) as count, country_state_towns.state, bids.status_id, country_state_towns.id'))
            ->groupBy('country_state_towns.state', 'bids.status_id')
            ->get();

        $refined_bids_group_by_location_array = array();
        if(count($bids_group_by_location) > 0){
            foreach($bids_group_by_location as $bid_location_key => $bid_location){
                if(!array_key_exists($bid_location->status_id, $refined_bids_group_by_location_array)){
                    $refined_bids_group_by_location_array[$bid_location->id]['success'] = 0;
                    $refined_bids_group_by_location_array[$bid_location->id]['failure'] = 0;
                    $refined_bids_group_by_location_array[$bid_location->id]['other'] = 0;
                }
                if($bid_location->status_id == '6'){
                    $refined_bids_group_by_location_array[$bid_location->id]['success'] = $bid_location->count;
                    $refined_bids_group_by_location_array[$bid_location->id]['state'] = $bid_location->state;
                }else if($bid_location->status_id == '10'){
                    $refined_bids_group_by_location_array[$bid_location->id]['failure'] = $bid_location->count;
                    $refined_bids_group_by_location_array[$bid_location->id]['state'] = $bid_location->state;
                }else{
                    $refined_bids_group_by_location_array[$bid_location->id]['other'] = $bid_location->count;
                    $refined_bids_group_by_location_array[$bid_location->id]['state'] = $bid_location->state;
                }
            }
        }

        if($export_type == 'report'){
            return view('report.report_7', compact('refined_bids_group_by_industry_array', 'refined_bids_group_by_location_array'));
        }else{
            Excel::create('Positioning Performance Report', function($excel) use ($refined_bids_group_by_industry_array, $refined_bids_group_by_location_array) {

                $excel->sheet('New sheet', function($sheet) use ($refined_bids_group_by_industry_array, $refined_bids_group_by_location_array) {

                    $sheet->loadView('report.report_7', array('refined_bids_group_by_industry_array' => $refined_bids_group_by_industry_array, 'refined_bids_group_by_location_array' => $refined_bids_group_by_location_array));

                });

            })->export('csv');
        }
    }

    //report 8
    public function ratingPerformance($start_date, $end_date, $export_type, $company_id){
        if(\Auth::user()->company_id){
            $company_id = \Auth::user()->company_id;
        }

        $ratings = Rating::where('company_id', $company_id)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();
        $cost = 0;
        $environment = 0;
        $technology = 0;
        $responsiveness = 0;
        $aos = 0;
        $quality = 0;
        foreach($ratings as $rating){
            $cost+=$rating->c;
            $environment+=$rating->e;
            $technology+=$rating->t;
            $responsiveness+=$rating->r;
            $aos+=$rating->a;
            $quality+=$rating->q;
        }

        $refined_rating_array = array(
            'cost' => $cost,
            'environment' => $environment,
            'technology' => $technology,
            'responsiveness' => $responsiveness,
            'aos' => $aos,
            'quality' => $quality,
            'total_star' => count($ratings) * 5
        );

        if($export_type == 'report'){
            return view('report.report_8', compact('refined_rating_array'));
        }else{
            Excel::create('Rating Performance Report', function($excel) use ($refined_rating_array) {

                $excel->sheet('New sheet', function($sheet) use ($refined_rating_array) {

                    $sheet->loadView('report.report_8', array('refined_rating_array' => $refined_rating_array));

                });

            })->export('csv');
        }
    }

    //report 9
    public function outsourcingTrend($start_date, $end_date, $export_type, $company_id){
        if(\Auth::user()->company_id){
            $company_id = \Auth::user()->company_id;
        }

        $jobs_group_by_industry_and_location = Industry::leftJoin('company_industry', 'company_industry.industry_id', '=', 'industries.id')
            ->leftJoin('jobs', function($join) use ($start_date, $end_date, $company_id)
            {
                $join->on('jobs.company_id', '=', 'company_industry.company_id')
                    ->where('jobs.created_at', '>=', $start_date)
                    ->where('jobs.created_at', '<=', $end_date)
                    ->where('jobs.company_id', '=', $company_id)
                    ->whereIn('jobs.status_id', [1, 4, 5, 6]);
            })
            ->leftJoin('country_state_towns', 'country_state_towns.id', '=', 'jobs.location_id')
            ->select(\DB::raw('count(jobs.id) as count, country_state_towns.state, industries.industry, industries.id, country_state_towns.id as location_id'))
            ->groupBy('industries.industry', 'country_state_towns.state')
            ->get();

        $refined_array = array();
        $states = array();
        if(count($jobs_group_by_industry_and_location) > 0){
            foreach($jobs_group_by_industry_and_location as $job){
                if(!in_array($job->state, $states)){
                    if(!empty($job->location_id)){
                        $states[$job->location_id] = $job->state;
                    }
                }
                $refined_array[$job->id]['industry'] = $job->industry;
                if(!empty($job->location_id)){
                    $refined_array[$job->id]['places'][$job->location_id] = $job->count;
                }else{
                    $refined_array[$job->id]['places'] = null;
                }
            }
        }

        if($export_type == 'report'){
            return view('report.report_9', compact('refined_array', 'states'));
        }else{
            Excel::create('Outsourcing Trend Report', function($excel) use ($refined_array, $states) {

                $excel->sheet('New sheet', function($sheet) use ($refined_array, $states) {

                    $sheet->loadView('report.report_9', array('refined_array' => $refined_array, 'states' => $states));

                });

            })->export('csv');
        }
    }

    //report 10
    public function lspDistribution($start_date, $end_date, $export_type, $company_id){

        if(\Auth::user()->company_id){
            $company_id = \Auth::user()->company_id;
        }

        $job_ids = Job::where('jobs.created_at', '>=', $start_date)->where('jobs.created_at', '<=', $end_date)->lists('id');
        $requirements = Requirement::with(array('jobs' => function($query) use ($start_date, $end_date)
        {
            $query->where('jobs.created_at', '>=', $start_date)->where('jobs.created_at', '<=', $end_date);
        },
            'jobs.valid_bids' => function($query) use ($job_ids)
            {
                $query->whereIn('bids.job_id', $job_ids);
            })
        )->get();
        foreach($requirements as $requirement_key => $requirement){
            $total_jobs = count($requirement->jobs);
            $total_bids_post_by_current_company = 0;
            $total_bids = 0;
            $job_bid_percentage = 0;
            $bid_percentage = 0;
            if($total_jobs > 0){
                foreach($requirement->jobs as $job){
                    $total_bids += count($job->valid_bids);
                    if(count($job->valid_bids) > 0){
                        foreach($job->valid_bids as $bid){
                            if($bid->company_id == $company_id){
                                $total_bids_post_by_current_company++;
                            }
                        }
                    }
                }
                if($total_jobs != 0){
                    $job_bid_percentage = $total_bids_post_by_current_company/$total_jobs * 100;
                }
                if($total_bids != 0){
                    $bid_percentage = $total_bids_post_by_current_company/$total_bids * 100;
                }
            }
            $requirements[$requirement_key]['total_jobs'] = $total_jobs;
            $requirements[$requirement_key]['total_bids'] = $total_bids;
            $requirements[$requirement_key]['total_bids_post_by_current_company'] = $total_bids_post_by_current_company;
            $requirements[$requirement_key]['job_bid_percentage'] = $job_bid_percentage;
            $requirements[$requirement_key]['bid_percentage'] = $bid_percentage;
        }

        if($export_type == 'report'){
            return view('report.report_10', compact('requirements'));
        }else{
            Excel::create('Future Demands Report', function($excel) use ($requirements) {

                $excel->sheet('New sheet', function($sheet) use ($requirements) {

                    $sheet->loadView('report.report_10', array('requirements' => $requirements));

                });

            })->export('csv');
        }
    }

    public function compareReport(Request $request){
        $job_id = $request->job_id;
        $bids_id = $request->bids_id;
        $job = Job::with('requirements', 'potentials', 'highlights')->find($job_id)->toArray();

        $features_for_job_poster_company = CompanyFeature::where('company_id', 1)->get();
        $bids = Bid::with('company', 'company.features', 'company.ratings', 'company.requirements_with_name_only', 'company.potentials_with_name_only')->whereIn('bids.id', $bids_id)->get()->toArray();

        //dd($bids);

        if(count($features_for_job_poster_company) > 0){
            foreach($features_for_job_poster_company as $feature){
                switch ($feature->feature){
                    case 'Equipment':
                        $job['equipment'][] = $feature->toArray();
                        break;
                    case 'Safety and Health':
                        $job['safety_and_health'][] = $feature->toArray();
                        break;
                    case 'Environmental':
                        $job['environmental'][] = $feature->toArray();
                        break;
                    case 'Technology':
                        $job['technology'][] = $feature->toArray();
                        break;
                    case 'Liability and Claims':
                        $job['liability_and_claims'][] = $feature->toArray();
                        break;
                    case 'Blacklist':
                        $job['blacklist'][] = $feature->toArray();
                        break;
                    case 'Innovative Power':
                        $job['innovative_power'][] = $feature->toArray();
                        break;
                    case 'Quality':
                        $job['quality'][] = $feature->toArray();
                        break;
                    case 'Certification':
                        $job['certification'][] = $feature->toArray();
                        break;
                    case 'Past Experiences':
                        $job['past_experiences'][] = $feature->toArray();
                        break;
                    case 'Security':
                        $job['security'][] = $feature->toArray();
                        break;
                    case 'Trade Compliance':
                        $job['trade_compliance'][] = $feature->toArray();
                        break;
                    case 'Assurance of Supply':
                        $job['assurance_of_supply'][] = $feature->toArray();
                        break;
                    case 'Responsiveness':
                        $job['responsiveness'][] = $feature->toArray();
                        break;
                    case 'Scalability/Growth':
                        $job['scalability_growth'][] = $feature->toArray();
                        break;
                }
            }
        }


        if(count($bids) > 0){
            foreach($bids as $bid_key => $bid){
                $c = 0;
                $e = 0;
                $t = 0;
                $r = 0;
                $a = 0;
                $q = 0;

                $count_success_bids = Bid::where('company_id', $bid['company']['id'])->where('status_id', 6)->count();
                $bids[$bid_key]['company']['past_project_awarded'] = $count_success_bids;

                if(count($bid['company']['features']) > 0){
                    foreach($bid['company']['features'] as $features_key => $feature){
                        switch ($feature['feature']){
                            case 'Equipment':
                                $bids[$bid_key]['company']['equipment'][] = $feature;
                                array_forget($bids[$bid_key]['company']['features'], $features_key);
                                break;
                            case 'Safety and Health':
                                $bids[$bid_key]['company']['safety_and_health'][] = $feature;
                                break;
                            case 'Environmental':
                                $bids[$bid_key]['company']['environmental'][] = $feature;
                                break;
                            case 'Technology':
                                $bids[$bid_key]['company']['technology'][] = $feature;
                                break;
                            case 'Liability and Claims':
                                $bids[$bid_key]['company']['liability_and_claims'][] = $feature;
                                break;
                            case 'Blacklist':
                                $bids[$bid_key]['company']['blacklist'][] = $feature;
                                break;
                            case 'Innovative Power':
                                $bids[$bid_key]['company']['innovative_power'][] = $feature;
                                break;
                            case 'Quality':
                                $bids[$bid_key]['company']['quality'][] = $feature;
                                break;
                            case 'Certification':
                                $bids[$bid_key]['company']['certification'][] = $feature;
                                break;
                            case 'Past Experiences':
                                $bids[$bid_key]['company']['past_experiences'][] = $feature;
                                break;
                            case 'Security':
                                $bids[$bid_key]['company']['security'][] = $feature;
                                break;
                            case 'Trade Compliance':
                                $bids[$bid_key]['company']['trade_compliance'][] = $feature;
                                break;
                            case 'Assurance of Supply':
                                $bids[$bid_key]['company']['assurance_of_supply'][] = $feature;
                                break;
                            case 'Responsiveness':
                                $bids[$bid_key]['company']['responsiveness'][] = $feature;
                                break;
                            case 'Scalability/Growth':
                                $bids[$bid_key]['company']['scalability_growth'][] = $feature;
                                break;
                        }
                        array_forget($bids[$bid_key]['company']['features'], $features_key);
                    }
                }

                if(count($bid['company']['ratings']) > 0){
                    foreach($bid['company']['ratings'] as $rating){
                        $c+=$rating['c'];
                        $e+=$rating['e'];
                        $t+=$rating['t'];
                        $r+=$rating['r'];
                        $a+=$rating['a'];
                        $q+=$rating['q'];
                    }
                    $c = round($c/count($bid['company']['ratings']), 2);
                    $e = round($e/count($bid['company']['ratings']), 2);
                    $t = round($t/count($bid['company']['ratings']), 2);
                    $r = round($r/count($bid['company']['ratings']), 2);
                    $a = round($a/count($bid['company']['ratings']), 2);
                    $q = round($q/count($bid['company']['ratings']), 2);
                }
                $bids[$bid_key]['company']['c'] = $c;
                $bids[$bid_key]['company']['e'] = $e;
                $bids[$bid_key]['company']['t'] = $t;
                $bids[$bid_key]['company']['r'] = $r;
                $bids[$bid_key]['company']['a'] = $a;
                $bids[$bid_key]['company']['q'] = $q;

                $now = Carbon::now();
                $diff = $now->diffInYears(Carbon::parse($bids[$bid_key]['company']['date_operation_started']));
                $bids[$bid_key]['company']['duration_in_business'] = $diff;
            }
        }
        //dd($bids);

        return view('report.compare_report', compact('job', 'bids'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(\Auth::user()->type == 'super_admin' || \Auth::user()->type == 'globe_admin'){
            $companies = Company::where('delete', 0)->lists('company_name', 'id');
        }
        return view('report.report', compact('companies'));
    }
}