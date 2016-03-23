<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\SystemLog;
use Maatwebsite\Excel\Facades\Excel;

class SystemLogsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //export logs into csv file
    public function exportLogs(Request $request){
        $start_date = $request->start_date_for_export;
        $end_date = $request->end_date_for_export;

        if($start_date != "" && $end_date != ""){
            $system_logs = SystemLog::orderBy('updated_at','desc')->with('createdBy')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();
        }else if($start_date != "" && $end_date == ""){
            $system_logs = SystemLog::orderBy('updated_at','desc')->with('createdBy')->where('created_at', '>=', $start_date)->get();
        }else if($start_date == "" && $end_date != ""){
            $system_logs = SystemLog::orderBy('updated_at','desc')->with('createdBy')->where('created_at', '<=', $end_date)->get();
        }else{
            $system_logs = SystemLog::orderBy('updated_at','desc')->with('createdBy')->get();
        }


        Excel::create('System Logs', function($excel) use ($system_logs) {

            $excel->sheet('New sheet', function($sheet) use ($system_logs) {

                $sheet->loadView('report.system_logs', array('system_logs' => $system_logs));

            });

        })->export('csv');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $system_logs = SystemLog::orderBy('updated_at','desc')->with('createdBy')->get();

        //dd($system_logs->toArray());

        return view('log.index', compact('system_logs'));
    }

    /**
     * Display a listing of system log with selected date range.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLogs(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        
        if($start_date != "" && $end_date != ""){
            $system_logs = SystemLog::orderBy('updated_at','desc')->with('createdBy')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->get();
        }else if($start_date != "" && $end_date == ""){
            $system_logs = SystemLog::orderBy('updated_at','desc')->with('createdBy')->where('created_at', '>=', $start_date)->get();
        }else if($start_date == "" && $end_date != ""){
            $system_logs = SystemLog::orderBy('updated_at','desc')->with('createdBy')->where('created_at', '<=', $end_date)->get();
        }else{
            $system_logs = SystemLog::orderBy('updated_at','desc')->with('createdBy')->get();
        }
        
        //dd($system_logs->toArray());

        return view('log.index', compact('system_logs', 'start_date', 'end_date'));
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