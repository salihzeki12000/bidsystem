<?php

namespace App\Http\Controllers;

use App\RfiState;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\Requirement;
use App\Potential;
use App\JobFile;
use App\FileType;
use App\CountryStateTown;
use App\Highlight;

class JobsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::where('delete', '!=', 1)->with('company')->with('rfi_status')->select('id', 'contract_term', 'company_id', 'location_id', 'status_id')->get();

        return view('job.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $requirements = Requirement::all();
        $potentials = Potential::all();
        $highlights = Highlight::all();
        $locations = CountryStateTown::all();

        if(\Auth::user()->type == 'super_admin' || \Auth::user()->type == 'globe_admin'){
            $companies = Company::where('category', 'Outsourcing')->where('delete', '0')->get();
        }

        return view('job.create', compact('requirements', 'potentials', 'companies', 'locations', 'highlights'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //var_dump($request->all());
        $refined_date_date = date('Y-m-d', strtotime($request->input('date')));
        $refined_close_date = date('Y-m-d H:i', strtotime($request->input('close_date')));
        $refined_announcement_date = date('Y-m-d H:i', strtotime($request->input('announcement_date')));
        $refined_outsource_date = date('Y-m-d H:i', strtotime($request->input('outsource_date')));

        $company_id = null;
        if(\Auth::user()->type == 'super_admin' || \Auth::user()->type == 'globe_admin'){
            $company_id = $request->admin_company;
        }else{
            $company_id = $request->company_id;
        }

        $job_array = array(
            'company_id' => $company_id,
            'date' => $refined_date_date,
            'location_id' => $request->location,
            'additional_description' => $request->description,
            'special_request' => $request->special_request,
            'existing_budget' => $request->existing_budget,
            'existing_lsp' => $request->existing_lsp,
            'contract_term' => $request->contract_term,
            'close_date' => $refined_close_date,
            'announcement_date' => $refined_announcement_date,
            'outsource_start_date' => $refined_outsource_date,
            'status_id' => 1,
            //'keyword' => $request->keyword,
            'created_by' => \Auth::id()
        );

        $new_job = Job::create($job_array);
        if($new_job){
            foreach($request->requirement as $requirement){
                $requirement_array[$requirement]['created_by'] = \Auth::id();
                $requirement_array[$requirement]['created_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                $requirement_array[$requirement]['updated_at'] = (new \DateTime())->format('Y-m-d H:i:s');
            }
            foreach($request->potential as $potential){
                $potential_array[$potential]['created_by'] = \Auth::id();
                $potential_array[$potential]['created_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                $potential_array[$potential]['updated_at'] = (new \DateTime())->format('Y-m-d H:i:s');
            }
            foreach($request->highlight as $highlight){
                $highlight_array[$highlight]['created_by'] = \Auth::id();
                $highlight_array[$highlight]['created_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                $highlight_array[$highlight]['updated_at'] = (new \DateTime())->format('Y-m-d H:i:s');
            }
            $new_job->requirements()->attach($requirement_array);
            $new_job->potentials()->attach($potential_array);
            $new_job->highlights()->attach($highlight_array);
            \Session::flash('success_message', 'Job has been saved successfully.');
            return redirect('/job');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Job::with('company')->with('requirements')->with('potentials')->with('highlights')->with('rfi_status')->with('files')->find($id);

        $new_date = strtotime($job->date);
        $job->date = date('d-m-Y', $new_date);

        $new_close_date = strtotime($job->close_date);
        $job->close_date = date('d-m-Y H:i', $new_close_date);

        $new_announcement_date = strtotime($job->announcement_date);
        $job->announcement_date = date('d-m-Y H:i', $new_announcement_date);

        $new_outsource_start_date = strtotime($job->outsource_start_date);
        $job->outsource_start_date = date('d-m-Y H:i', $new_outsource_start_date);

        return view('job.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = Job::with('company')->with('rfi_status')->with('files')->with('requirements')->with('potentials')->find($id);
        $requirements = Requirement::lists('requirement', 'id');
        $potentials = Potential::lists('potential', 'id');
        $highlights = Highlight::lists('highlight', 'id');
        $locations = CountryStateTown::all();
        $rfi_status = RfiState::where('available_for_job', 1)->get();

        $selected_requirements = array();
        $selected_potentials = array();
        $selected_highlights = array();
        foreach($job->requirements as $requirement){
            $selected_requirements[$requirement->pivot->id] = $requirement->id;
        }

        foreach($job->potentials as $potential){
            $selected_potentials[$potential->pivot->id] = $potential->id;
        }

        foreach($job->highlights as $highlight){
            $selected_highlights[$highlight->pivot->id] = $highlight->id;
        }

        $job->date = date('d-m-Y', strtotime($job->date));
        $job->close_date = date('d-m-Y H:i', strtotime($job->close_date));
        $job->announcement_date = date('d-m-Y H:i', strtotime($job->announcement_date));
        $job->outsource_start_date = date('d-m-Y H:i', strtotime($job->outsource_start_date));

        return view('job.edit', compact('job', 'requirements', 'potentials', 'rfi_status', 'locations', 'selected_requirements', 'selected_potentials', 'highlights', 'selected_highlights'));
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
        $refined_date_date = date('Y-m-d', strtotime($request->input('date')));
        $refined_close_date = date('Y-m-d H:i', strtotime($request->input('close_date')));
        $refined_announcement_date = date('Y-m-d H:i', strtotime($request->input('announcement_date')));
        $refined_outsource_date = date('Y-m-d H:i', strtotime($request->input('outsource_date')));

        $job_array = array(
            'date' => $refined_date_date,
            'location_id' => $request->location,
            'additional_description' => $request->description,
            'special_request' => $request->special_request,
            'existing_budget' => $request->existing_budget,
            'existing_lsp' => $request->existing_lsp,
            'contract_term' => $request->contract_term,
            'close_date' => $refined_close_date,
            'announcement_date' => $refined_announcement_date,
            'outsource_start_date' => $refined_outsource_date,
            'status_id' => $request->status,
            //'keyword' => $request->keyword,
            'modified_by' => \Auth::id()
        );
        $job = Job::with('requirements')->with('potentials')->find($id);
        $job->fill($job_array);
        if($job->save()){
            $selected_requirements = array();
            $selected_potentials = array();
            $selected_highlights = array();

            foreach($job->requirements as $requirement){
                $selected_requirements[$requirement->pivot->id] = $requirement->id;
            }

            foreach($job->potentials as $potential){
                $selected_potentials[$potential->pivot->id] = $potential->id;
            }

            foreach($job->highlights as $highlight){
                $selected_highlights[$highlight->pivot->id] = $highlight->id;
            }

            $delete_requirements_different = array_diff($selected_requirements, $request->requirement);
            $new_requirements_different = array_diff($request->requirement, $selected_requirements);
            if(count($delete_requirements_different) > 0){
                $job->requirements()->detach($delete_requirements_different);
            }
            if(count($new_requirements_different) > 0){
                foreach($new_requirements_different as $new_requirement){
                    $requirement_array[$new_requirement]['created_by'] = \Auth::id();
                    $requirement_array[$new_requirement]['created_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                    $requirement_array[$new_requirement]['updated_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                }
                $job->requirements()->attach($requirement_array);
            }

            $delete_potential_different = array_diff($selected_potentials, $request->potential);
            $new_potential_different = array_diff($request->potential, $selected_potentials);
            if(count($delete_potential_different) > 0){
                $job->potentials()->detach($delete_requirements_different);
            }
            if(count($new_potential_different) > 0){
                foreach($new_potential_different as $new_potential){
                    $potential_array[$new_potential]['created_by'] = \Auth::id();
                    $potential_array[$new_potential]['created_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                    $potential_array[$new_potential]['updated_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                }
                $job->potentials()->attach($potential_array);
            }

            $delete_highlight_different = array_diff($selected_highlights, $request->highlight);
            $new_highlight_different = array_diff($request->highlight, $selected_highlights);
            if(count($delete_highlight_different) > 0){
                $job->highlights()->detach($delete_highlight_different);
            }
            if(count($new_highlight_different) > 0){
                foreach($new_highlight_different as $new_highlight){
                    $highlight_array[$new_highlight]['created_by'] = \Auth::id();
                    $highlight_array[$new_highlight]['created_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                    $highlight_array[$new_highlight]['updated_at'] = (new \DateTime())->format('Y-m-d H:i:s');
                }
                $job->highlights()->attach($highlight_array);
            }

            \Session::flash('success_message', 'Job has been updated successfully.');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete = 1;
        $job->save();

        \Session::flash('success_message', 'Job has been deleted successfully.');
        return redirect('/job');
    }

    public function manageJobFiles($id)
    {
        $job = Job::with('files')->findOrFail($id);
        $file_types = FileType::all();

        //put files into different categories
        $invoice_files = array();
        $dn_files = array();
        $cn_files = array();
        $logo_files = array();
        $profile_files = array();
        $support_files = array();
        $registration_files = array();
        $others_files = array();
        if(!empty($job->files)){
            foreach($job->files as $file){
                switch ($file->file_type_id) {
                    case '1':
                        $invoice_files[] = $file;
                        break;
                    case '2':
                        $dn_files[] = $file;
                        break;
                    case '3':
                        $cn_files[] = $file;
                        break;
                    case '4':
                        $logo_files[] = $file;
                        break;
                    case '5':
                        $profile_files[] = $file;
                        break;
                    case '6':
                        $support_files[] = $file;
                        break;
                    case '7':
                        $registration_files[] = $file;
                        break;
                    case '8':
                        $others_files[] = $file;
                        break;
                }
            }
        }

        return view('job.manage_job_files', compact('job', 'invoice_files', 'dn_files', 'cn_files', 'logo_files', 'profile_files', 'support_files', 'registration_files', 'others_files', 'file_types'));
    }

    /**
     * Save job files.
     */
    public function saveJobFile(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        if($request->file('file')){
            $destination_path = public_path().sprintf('/uploads/%s/job_files/job_id_%s/', $job->company_id, $id);
            if($request->file('file')->isValid()){
                $file_name = $request->file('file')->getClientOriginalName();
                if($request->file('file')->move($destination_path, $file_name)){
                    $file_array = array(
                        'job_id' => $id,
                        'file_type_id' => $request->input('file_type'),
                        'file_name' => $request->input('file_name'),
                        'link_path' => \URL::asset('uploads/'.$job->company_id.'/job_files/job_id_'.$id.'/'.$file_name),
                        'status' => 'Active',
                        'created_by' => \Auth::id()
                    );

                    if(JobFile::create($file_array)){
                        \Session::flash('success_message', 'File has been uploaded successfully.');
                        return redirect()->back();
                    }else{
                        \Session::flash('alert_message', 'File cannot be saved.');
                        return redirect()->back()->withInput();
                    }
                }else{
                    \Session::flash('alert_message', 'File cannot be saved.');
                    return redirect()->back()->withInput();
                }
            }else{
                \Session::flash('alert_message', 'Invalid file.');
                return redirect()->back()->withInput();
            }
        }

        return redirect('/job/manage_job_files/'.$id);
    }

    /**
     * remove job files.
     */
    public function deleteJobFile($file_id, $company_id)
    {
        $job_file = JobFile::findOrFail($file_id);
        $status = false;

        $split_file_path = explode('/', $job_file->link_path);
        $file_name = $split_file_path[count($split_file_path)-1];
        $old_file_path= public_path().'/uploads/'.$company_id.'/job_files/job_id_'.$job_file->job_id.'/'.$file_name;

        if(\File::delete($old_file_path) && $job_file->delete()){
            $status = true;
        }

        return response()->json(['status' => $status]);
    }

}