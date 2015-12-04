<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AppointmentObjectives;
use App\AppointmentRequest;
use App\AppointmentResponse;
use Carbon\Carbon;

class AppointmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the appointment.
     */
    public function showAllAppointments($id)
    {
        $received_appointments = AppointmentRequest::where('receiver', $id)->with('response', 'get_sender', 'get_receiver', 'objective')->orderBy('updated_at', 'desc')->get();
        $sent_appointments = AppointmentRequest::Where('sender', $id)->with('response', 'get_sender', 'get_receiver', 'objective')->orderBy('updated_at', 'desc')->get();

        $appointment_objectives = AppointmentObjectives::lists('app_objective', 'id');
        $companies = Company::lists('company_name', 'id');

        $current_time = Carbon::now();
        $now = $current_time->toDateTimeString();

        foreach($received_appointments as $appointment_key => $appointment){
            if($appointment->date_time > $now){
                $appointments[$appointment_key]['expired'] = 0;
            }else{
                $appointments[$appointment_key]['expired'] = 1;
            }
        }

        foreach($sent_appointments as $appointment_key => $appointment){
            $new_date_time = strtotime($appointment->date_time);
            $sent_appointments[$appointment_key]['date_time'] = date('d-m-Y H:i', $new_date_time);
        }

        //var_dump($received_appointments->toArray());

        $current_time = Carbon::now();
        $now = $current_time->toDateTimeString();

        return view('appointment.show_all_appointments', compact('received_appointments', 'appointment_objectives', 'companies', 'now', 'sent_appointments'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = AppointmentRequest::with('get_sender', 'get_receiver', 'objective')->get();
        $appointment_response = AppointmentResponse::all();

        //dd($appointment_response->toArray());
        $appointment_objectives = AppointmentObjectives::lists('app_objective', 'id');
        $companies = Company::lists('company_name', 'id');

        return view('appointment.index', compact('appointments', 'appointment_objectives', 'companies', 'appointment_response'));
    }

    /**
     * response to appointment request
     */
    public function responseToAppointmentRequest(Request $request)
    {
        if($request->answer_to_appointment == 'Accept'){
            $request->comment = null;
        }

        $answer_array = array(
            'appointment_request_id' => $request->appointment_request_id,
            'description' => $request->comment,
            'response_action' => $request->answer_to_appointment,
            'created_by' => \Auth::user()->id
        );

        $new_response = AppointmentResponse::create($answer_array);

        $appointment_request = AppointmentRequest::find($request->appointment_request_id);
        if($request->answer_to_appointment == 'Request to modify'){
            $appointment_request->status = 'Unconfirmed';
        }else{
            $appointment_request->status = 'Confirmed';
        }
        $appointment_request->save();

        if($new_response){
            \Session::flash('success_message', 'Appointment response has been sent.');
        }else{
            \Session::flash('alert_message', 'Appointment response cannot be sent.');
        }

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //var_dump($request->all());
        $sender = $request->sender_id;
        if(empty($sender)){
            $sender = \Auth::user()->company_id;
        }

        $refined_date_time = date('Y-m-d H:i', strtotime($request->appointment_date));

        $appointment_array = array(
            'sender' => $sender,
            'receiver' => $request->appointment_receiver,
            'no_of_pic' => $request->appointment_no_of_pic,
            'objective_id' => $request->appointment_objective,
            'description' => $request->appointment_description,
            'location' => $request->appointment_location,
            'date_time' => $refined_date_time,
            'status' => 'Unconfirmed',
            'created_by' => \Auth::user()->id
        );

        $new_appointment =  AppointmentRequest::create($appointment_array);

        if($new_appointment){
            \Session::flash('success_message', 'Appointment has been sent.');
        }else{
            \Session::flash('alert_message', 'Appointment cannot be sent.');
        }

        return redirect()->back();
    }

    /**
     * Update appointment
     */
    public function modifyAppointment(Request $request, $id)
    {
        $refined_date_time = date('Y-m-d H:i', strtotime($request->appointment_date));

        $appointment_request = AppointmentRequest::find($id);
        $appointment_request->no_of_pic = $request->no_of_pic;
        $appointment_request->objective_id = $request->appointment_objective;
        $appointment_request->description = $request->appointment_description;
        $appointment_request->location = $request->location;
        $appointment_request->date_time = $refined_date_time;
        $appointment_request->status = 'Unconfirmed';
        if($request->appointment_status){
            $appointment_request->status = $request->appointment_status;
        }

        if($appointment_request->save()){
            \Session::flash('success_message', 'Appointment has been updated.');
        }else{
            \Session::flash('alert_message', 'Appointment cannot be updated.');
        }

        return redirect()->back();
    }

    /**
     * Update appointment response
     */
    public function modifyAppointmentResponse(Request $request, $id)
    {
        $appointment_response = AppointmentResponse::findOrFail($id);
        $appointment_response->description = $request->response_description;
        $appointment_response->response_action = $request->response_action;

        if($appointment_response->save()){
            \Session::flash('success_message', 'Appointment response has been updated.');
        }else{
            \Session::flash('alert_message', 'Appointment response cannot be updated.');
        }

        return redirect()->back();
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