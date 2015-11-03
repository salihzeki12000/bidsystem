<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\Company;
use Carbon\Carbon;
use App\Bid;

class HomesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $new_jobs = Job::with('company')->where('status_id', 4)->where('created_at', '>=', Carbon::now()->startOfMonth())->where('created_at', '<=', Carbon::now()->endOfMonth())->get();
        $new_bids = Bid::with('company')->where('status_id', 7)->where('created_at', '>=', Carbon::now()->startOfMonth())->where('created_at', '<=', Carbon::now()->endOfMonth())->get();
        $new_lsp = Company::where('category', 'LSP')->where('created_at', '>=', Carbon::now()->startOfMonth())->where('created_at', '<=', Carbon::now()->endOfMonth())->get();
        $new_outsourcer = Company::where('category', 'Outsourcing')->where('created_at', '>=', Carbon::now()->startOfMonth())->where('created_at', '<=', Carbon::now()->endOfMonth())->get();
        $current_month = Carbon::now()->month;
        switch ($current_month){
            case 1:
                $current_month = 'January';
                break;
            case 2:
                $current_month = 'February';
                break;
            case 3:
                $current_month = 'March';
                break;
            case 4:
                $current_month = 'April';
                break;
            case 5:
                $current_month = 'May';
                break;
            case 6:
                $current_month = 'June';
                break;
            case 7:
                $current_month = 'July';
                break;
            case 8:
                $current_month = 'August';
                break;
            case 9:
                $current_month = 'September';
                break;
            case 10:
                $current_month = 'October';
                break;
            case 11:
                $current_month = 'November';
                break;
            case 12:
                $current_month = 'December';
                break;
            default:
                break;
        }

        return view('home.index', compact('new_jobs', 'new_lsp', 'new_outsourcer', 'current_month', 'new_bids'));
    }

    /**
     * show company list.
     */
    public function companyList()
    {
        return view('home.company_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}