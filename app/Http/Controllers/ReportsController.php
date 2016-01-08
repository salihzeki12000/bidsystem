<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Company;
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

        //return response()->json(['result' => $jobs]);
        return view('report.report_1', compact('jobs'));
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

        if($days > 0){
            foreach($jobs as $job_key => $job){
                $performance = 0;
                $total_valid_bids_posted = $job->valid_bids()->count();
                $performance = round($total_valid_bids_posted / $days, 3);
                $jobs[$job_key]['performance'] = $performance;
                $jobs[$job_key]['number_of_days'] = $days;
                $jobs[$job_key]['total_bids'] = $total_valid_bids_posted;
            }
        }

        //return response()->json(['result' => $jobs]);
        return view('report.report_2', compact('jobs'));
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


    //report 6
    public function bidPerformance(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $companies = Company::with('bids')->where('companies.category', '=','LSP')->get();

        foreach($companies as $company_key => $company){
            $count_success = 0;
            $count_pending = 0;
            $count_failure = 0;
            if(count($company->bids) > 0){
                foreach($company->bids as $bid_key => $bid){
                    if($bid->created_at >= $start_date && $bid->created_at <= $end_date){
                        if(in_array($bid->status_id, [10])){
                            $count_failure++;
                        }elseif(in_array($bid->status_id, [6])){
                            $count_success++;
                        }else{
                            $count_pending++;
                        }
                    }else{
                        unset($company->bids[$bid_key]);
                    }
                }
            }
            $companies[$company_key]['success_bids'] = $count_success;
            $companies[$company_key]['failure_bids'] = $count_failure;
            $companies[$company_key]['pending_bids'] = $count_pending;
        }

        return response()->json(['result' => $companies]);
    }

    //report 8
    public function ratingLsp(Request $request){
        $ratings = Rating:: orderBy('company_id', 'desc')->get();

        return response()->json(['result' => $ratings]);
    }

    //report 9
    public function outsourcingTrend(){
        $jobs = DB::select('SELECT MONTH(created_at) as month, company_id, COUNT(id) as number_of_jobs FROM jobs GROUP BY MONTH(created_at), company_id');

        //dd($jobs);

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
        return view('report.outsourcing_trend', compact('jobs'));
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


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}