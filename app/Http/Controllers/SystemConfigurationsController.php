<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Industry;
use App\Highlight;
use App\Potential;
use App\CountryStateTown;
use App\Requirement;
use App\TicketCategory;
use App\AppointmentObjectives;
use Gate;

class SystemConfigurationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request){
        $status = false;
        $id = null;
        switch($request->type){
            case 'industry':
                $industry_array = array(
                    'industry' => $request->value,
                    'status' => 'Active',
                    'created_by' => \Auth::user()->id
                );
                $new_industry = Industry::create($industry_array);
                if($new_industry) {
                    $status = true;
                    $id = $new_industry->id;
                }
                break;
            case 'highlight':
                $highlight_array = array(
                    'highlight' => $request->value,
                    'status' => 'Active',
                    'created_by' => \Auth::user()->id
                );
                $new_highlight = Highlight::create($highlight_array);
                if($new_highlight) {
                    $status = true;
                    $id = $new_highlight->id;
                }
                break;
            case 'potential':
                $potential_array = array(
                    'potential' => $request->value,
                    'status' => 'Active',
                    'created_by' => \Auth::user()->id
                );
                $new_potential = Potential::create($potential_array);
                if($new_potential) {
                    $status = true;
                    $id = $new_potential->id;
                }
                break;
            case 'requirement':
                $requirement_array = array(
                    'requirement' => $request->value,
                    'status' => 'Active',
                    'created_by' => \Auth::user()->id
                );
                $new_requirement = Requirement::create($requirement_array);
                if($new_requirement) {
                    $status = true;
                    $id = $new_requirement->id;
                }
                break;
            case 'ticket':
                $ticket_array = array(
                    'name' => $request->value,
                    'status' => 'Active',
                    'created_by' => \Auth::user()->id
                );
                $new_ticket = TicketCategory::create($ticket_array);
                if($new_ticket) {
                    $status = true;
                    $id = $new_ticket->id;
                }
                break;
            case 'location':
                $location_array = array(
                    'town' => $request->town,
                    'state' => $request->state,
                    'country' => $request->country,
                    'postcode' => $request->postcode,
                    'status' => 'Active',
                    'created_by' => \Auth::user()->id
                );
                $new_location = CountryStateTown::create($location_array);
                if($new_location) {
                    $status = true;
                    $id = $new_location->id;
                }
                break;
            case 'appointment':
                $appointment_array = array(
                    'app_objective' => $request->value,
                    'status' => 'Active',
                    'created_by' => \Auth::user()->id
                );
                $new_appointment = AppointmentObjectives::create($appointment_array);
                if($new_appointment) {
                    $status = true;
                    $id = $new_appointment->id;
                }
                break;
        }

        return response()->json(['status' => $status, 'id' => $id]);
    }

    public function edit(Request $request){
        $status = false;
        switch($request->type){
            case 'industry':
                $industry = Industry::findOrFail($request->id);
                $industry->industry = $request->value;
                $industry->modified_by = \Auth::user()->id;

                if($industry->save()) {
                    $status = true;
                }
                break;
            case 'highlight':
                $highlight = Highlight::findOrFail($request->id);
                $highlight->highlight = $request->value;
                $highlight->modified_by = \Auth::user()->id;

                if($highlight->save()){
                    $status = true;
                }
                break;
            case 'potential':
                $potential = Potential::findOrFail($request->id);
                $potential->potential = $request->value;
                $potential->modified_by = \Auth::user()->id;

                if($potential->save()){
                    $status = true;
                }
                break;
            case 'requirement':
                $requirement = Requirement::findOrFail($request->id);
                $requirement->requirement = $request->value;
                $requirement->modified_by = \Auth::user()->id;

                if($requirement->save()){
                    $status = true;
                }
                break;
            case 'ticket':
                $ticket = TicketCategory::findOrFail($request->id);
                $ticket->name = $request->value;
                $ticket->modified_by = \Auth::user()->id;

                if($ticket->save()){
                    $status = true;
                }
                break;
            case 'appointment':
                $appointment = AppointmentObjectives::findOrFail($request->id);
                $appointment->app_objective = $request->value;
                $appointment->modified_by = \Auth::user()->id;

                if($appointment->save()){
                    $status = true;
                }
                break;
            case 'location':
                $location = CountryStateTown::findOrFail($request->id);
                $location->town = $request->town;
                $location->state = $request->state;
                $location->country = $request->country;
                $location->postcode = $request->postcode;
                $location->modified_by = \Auth::user()->id;

                if($location->save()){
                    $status = true;
                }
                break;
        }

        return response()->json(['status' => $status]);
    }

    public function delete(Request $request){
        $status = false;
        switch($request->type){
            case 'industry':
                if(Industry::where('id', $request->id)->delete()) {
                    $status = true;
                }
                break;
            case 'highlight':
                if(Highlight::where('id', $request->id)->delete()) {
                    $status = true;
                }
                break;
            case 'potential':
                if(Potential::where('id', $request->id)->delete()) {
                    $status = true;
                }
                break;
            case 'requirement':
                if(Requirement::where('id', $request->id)->delete()) {
                    $status = true;
                }
                break;
            case 'ticket':
                if(TicketCategory::where('id', $request->id)->delete()) {
                    $status = true;
                }
                break;
            case 'location':
                if(CountryStateTown::where('id', $request->id)->delete()) {
                    $status = true;
                }
                break;
            case 'appointment':
                if(AppointmentObjectives::where('id', $request->id)->delete()) {
                    $status = true;
                }
                break;
        }

        return response()->json(['status' => $status]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('globe-admin-above')) {
            abort('403');
        }
        $industries = Industry::lists('industry', 'id');
        $highlights = Highlight::lists('highlight', 'id');
        $potentials = Potential::lists('potential', 'id');
        $locations = CountryStateTown::all();
        $requirements = Requirement::lists('requirement', 'id');
        $ticket_categories = TicketCategory::lists('name', 'id');
        $appointment_objectives = AppointmentObjectives::all();

        return view('system.index', compact('industries', 'highlights', 'potentials', 'locations', 'requirements', 'ticket_categories', 'appointment_objectives'));
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
