<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Company;
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

    //report 1
    public function jobManagement(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $company_id = $request->company_id;

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

        //return response()->json(['result' => $jobs]);
        return view('report.report_1', compact('jobs', 'count_draft', 'count_published', 'count_canceled', 'count_awarded'));
    }

    //report 2
    public function jobPerformance(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $start_date = new Carbon($start_date);
        $end_date = new Carbon($end_date);
        $days = $end_date->diffInDays($start_date);
        $company_id = $request->company_id;

        $jobs = Job::with('company')->where('company_id', $company_id)->get();
        $total_valid_bids_received = 0;

        if($days > 0){
            foreach($jobs as $job_key => $job){
                $performance = 0;
                $total_valid_bids_posted = $job->valid_bids()->count();
                $total_valid_bids_received+=$total_valid_bids_posted;
                $performance = round($total_valid_bids_posted / $days, 3);
                $jobs[$job_key]['performance'] = $performance;
                $jobs[$job_key]['number_of_days'] = $days;
                $jobs[$job_key]['total_bids'] = $total_valid_bids_posted;
            }
        }

        //return response()->json(['result' => $jobs]);
        return view('report.report_2', compact('jobs', 'total_valid_bids_received'));
    }


    //report 3
    public function compareBudget(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $jobs = Job::with('valid_bids')->get();

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

        //return response()->json(['result' => $jobs]);
        return view('report.report_3', compact('jobs'));
    }

    //report 4
    public function outsourceDistribution(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $company_id = $request->company_id;

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

        //return response()->json(['result' => $requirements]);
        return view('report.report_4', compact('requirements'));
    }

    //report 5
    public function targetManagement(Request $request){
        //dd($request->all());
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $company_id = $request->company_id;

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

        //return response()->json(['result' => bids]);
        return view('report.report_5', compact('bids', 'count_sales', 'count_open_bids'));
    }


    //report 6
    public function bidPerformance(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $company_id = $request->company_id;

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

        //return response()->json(['result' => $companies]);
        return view('report.report_6', compact('bids', 'count_success', 'count_failure'));
    }

    //report 7
    public function positioningPerformance(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $company_id = $request->company_id;

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

        //dd($bids_group_by_industry->toArray());
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
        //dd($refined_bids_group_by_industry_array);

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
        //dd($refined_bids_group_by_location_array);

        //return response()->json(['result' => $companies]);
        return view('report.report_7', compact('refined_bids_group_by_industry_array', 'refined_bids_group_by_location_array'));
    }

    //report 8
    public function ratingPerformance(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $company_id = $request->company_id;

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

        //dd($refined_rating_array);

        //return response()->json(['result' => $refined_rating_array]);
        return view('report.report_8', compact('refined_rating_array'));
    }

    //report 9
    public function outsourcingTrend(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $company_id = $request->company_id;


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

        //dd($jobs_group_by_industry_and_location->toArray());

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

        //dd($refined_array);

//        if(count($jobs) > 0){
//            foreach($jobs as $job){
//                $temp_array = array(
//                    'month' =>
//                );
//                dd($job->number_of_jobs);
//            }
//
//            Excel::create('Outsourcing trend', function($excel) use ($jobs) {
//
//                $excel->sheet('Sheet1', function($sheet) use ($jobs) {
//
//                    $sheet->fromArray(array(
//                        $jobs
//                    ));
//
//                });
//
//            })->export('csv');
//        }

        //return response()->json(['result' => $users]);
        return view('report.report_9', compact('refined_array', 'states'));
    }

    //report 10
    public function lspDistribution(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $company_id = $request->company_id;

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

        //return response()->json(['result' => $requirements]);
        return view('report.report_10', compact('requirements'));
    }

    public function generateCsvFromView(){
        $jobs = DB::select('SELECT MONTH(created_at) as month, company_id, COUNT(id) as number_of_jobs FROM jobs GROUP BY MONTH(created_at), company_id');

        Excel::create('New file', function($excel) use ($jobs) {

            $excel->sheet('New sheet', function($sheet) use ($jobs) {

                $sheet->loadView('report.outsourcing_trend', array('jobs' => $jobs));

            });

        })->export('csv');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('report.report');
    }
}