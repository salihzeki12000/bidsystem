<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Company;

class UserPerformancesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function userPerformance()
    {
        $companies = Company::select('id', 'company_name', 'created_at', 'category')->get();

        foreach($companies as $company_key => $company){
            $created = new Carbon($company->created_at);
            $now = Carbon::now();
            $days = $now->diffInDays($created);

            $performance = 0;

            if($days > 0){
                if($company->category == 'LSP'){
                    $total_valid_bids_posted = $company->valid_bids()->count();
                    $performance = round($total_valid_bids_posted / $days, 3);
                }else if($company->category == 'Outsourcing'){
                    $total_valid_jobs_posted = $company->valid_jobs()->count();
                    $performance = round($total_valid_jobs_posted / $days, 3);
                }
            }

            $companies[$company_key]['performance'] = $performance;
        }

        return view('user.user_performance', compact('companies'));
    }
}