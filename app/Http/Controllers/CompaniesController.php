<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Company;
use App\CompanyFile;
use App\CompanyAchievement;
use App\CompanyFeature;
use App\CompanyIndustry;
use App\CompanyRemark;
use App\CompanyRequirement;
use App\CompanyPotential;
use App\SystemLog;
use App\Industry;
use App\Achievement;
use App\Potential;
use App\Requirement;
use App\CompanyContact;
use App\Contact;
use App\Logistic;
use App\Service;
use App\CompanyLogistic;
use App\CompanyService;

class CompaniesController extends Controller
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
        $companies = Company::latest('updated_at')->where('delete', '0')->with('createdBy')->get();
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $industries = Industry::all();
        $requirements = Requirement::all();
        $potentials = Potential::all();
        $achievements = Achievement::all();
        $logistics = Logistic::all();
        $services = Service::all();

        return view('company.create', compact('industries', 'requirements', 'potentials', 'achievements', 'logistics', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $refined_joined_date = date('Y-m-d', strtotime($request->input('joined_date')));
        $refined_operation_date = date('Y-m-d', strtotime($request->input('operation_date')));

        if($request->input('gst') == 0){
            $gst_percent = 0;
        }else{
            $gst_percent = $request->input('gst_percent');
        }

        $company_array = array(
            'company_name' => $request->input('company_name'),
            'category' => $request->input('category'),
            'date_joined' => $refined_joined_date,
            'date_operation_started' => $refined_operation_date,
            'registration_num' => $request->input('registration_num'),
            'paid_up_capital' => $request->input('paid_up_capital'),
            'no_of_employees' => $request->input('no_of_employees'),
            'annual_turnover' => $request->input('annual_turnover'),
            'keyword' => $request->input('keyword'),
            'physical_file_number' => $request->input('physical_file_number'),
            'billing_period' => $request->input('billing_period'),
            'include_gst' => $request->input('gst'),
            'gst_percent' => $gst_percent,
            'status' => $request->input('status'),
            'account_quota' => $request->input('account_quota'),
            'created_by' => \Auth::id()
        );
        $company = Company::create($company_array);

        if($company){
            $company_main_contact_array = array(
                'company_id' => $company->id,
                'contact_type_id' => $request->input('contact_type'),
                'address_line_1' => $request->input('address_line_1'),
                'address_line_2' => $request->input('address_line_2'),
                'address_line_3' => $request->input('address_line_3'),
                'postcode' => $request->input('postcode'),
                'town' => $request->input('town'),
                'state' => $request->input('state'),
                'country' => $request->input('country'),
                'tel_num' => $request->input('tel_num'),
                'fax_num' => $request->input('fax_num'),
                'website' => $request->input('website'),
                'pic_name' => $request->input('pic_name'),
                'pic_department' => $request->input('pic_department'),
                'pic_designation' => $request->input('pic_designation'),
                'pic_mobile_num' => $request->input('pic_mobile_num'),
                'pic_email_1' => $request->input('pic_email_1'),
                'pic_email_2' => $request->input('pic_email_2'),
                'created_by' => \Auth::id()
            );
            $company_contact = CompanyContact::create($company_main_contact_array);

            $system_log_array = array(
                'action_type' => 'Create',
                'action_description' => env('CREATE_COMPANY_PROFILE_SUCCESS_MESSAGE'),
                'perform_by' => \Auth::user()->id,
                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                'target_id' => $company->id,
                'target_category' => 'Company',
                'result' => 'success',
            );
        }else{
            $system_log_array = array(
                'action_type' => 'Create',
                'action_description' => env('CREATE_COMPANY_PROFILE_FAIL_MESSAGE'),
                'perform_by' => \Auth::user()->id,
                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                'target_id' => null,
                'target_category' => 'Company',
                'result' => 'failed',
            );
        }
        SystemLog::create($system_log_array);

        //add new company logistic and service
        if($request->input('category') == 'LSP'){
            foreach($request->input('logistic') as $logistic){
                $logistic_array = array(
                    'company_id' => $company->id,
                    'logistic_id' => $logistic,
                    'status' => 'Status 1',
                    'created_by' => \Auth::id()
                );
                $new_logistic = CompanyLogistic::create($logistic_array);
                if($new_logistic){
                    $system_log_array = array(
                        'action_type' => 'Create',
                        'action_description' => env('CREATE_COMPANY_LOGISTIC_SUCCESS_MESSAGE'),
                        'perform_by' => \Auth::user()->id,
                        'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                        'target_id' => $new_logistic->id,
                        'target_category' => 'Company Logistic',
                        'result' => 'success',
                    );
                }else{
                    $system_log_array = array(
                        'action_type' => 'Create',
                        'action_description' => env('CREATE_COMPANY_LOGISTIC_FAIL_MESSAGE'),
                        'perform_by' => \Auth::user()->id,
                        'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                        'target_id' => null,
                        'target_category' => 'Company Logistic',
                        'result' => 'failed',
                    );
                }
                SystemLog::create($system_log_array);
            }

            foreach($request->input('service') as $service){
                $service_array = array(
                    'company_id' => $company->id,
                    'service_id' => $service,
                    'status' => 'Status 1',
                    'created_by' => \Auth::id()
                );
                $new_service = CompanyService::create($service_array);
                if($new_service){
                    $system_log_array = array(
                        'action_type' => 'Create',
                        'action_description' => env('CREATE_COMPANY_SERVICE_SUCCESS_MESSAGE'),
                        'perform_by' => \Auth::user()->id,
                        'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                        'target_id' => $new_service->id,
                        'target_category' => 'Company Service',
                        'result' => 'success',
                    );
                }else{
                    $system_log_array = array(
                        'action_type' => 'Create',
                        'action_description' => env('CREATE_COMPANY_SERVICE_FAIL_MESSAGE'),
                        'perform_by' => \Auth::user()->id,
                        'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                        'target_id' => null,
                        'target_category' => 'Company Service',
                        'result' => 'failed',
                    );
                }
                SystemLog::create($system_log_array);
            }
        }

        //add new company industry
        if(!empty($request->input('industry'))){
            foreach($request->input('industry') as $industry){
                $industry_array = array(
                    'company_id' => $company->id,
                    'industry_id' => $industry,
                    'status' => 'Status 1',
                    'created_by' => \Auth::id()
                );
                $new_industry = CompanyIndustry::create($industry_array);
                if($new_industry){
                    $system_log_array = array(
                        'action_type' => 'Create',
                        'action_description' => env('CREATE_COMPANY_INDUSTRY_SUCCESS_MESSAGE'),
                        'perform_by' => \Auth::user()->id,
                        'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                        'target_id' => $new_industry->id,
                        'target_category' => 'Company Industry',
                        'result' => 'success',
                    );
                }else{
                    $system_log_array = array(
                        'action_type' => 'Create',
                        'action_description' => env('CREATE_COMPANY_INDUSTRY_FAIL_MESSAGE'),
                        'perform_by' => \Auth::user()->id,
                        'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                        'target_id' => null,
                        'target_category' => 'Company Industry',
                        'result' => 'failed',
                    );
                }
                SystemLog::create($system_log_array);
            }
        }

        //add new company requirement
        if(!empty($request->input('requirement'))){
            foreach($request->input('requirement') as $requirement){
                $requirement_array = array(
                    'company_id' => $company->id,
                    'requirement_id' => $requirement,
                    'status' => 'Status 1',
                    'created_by' => \Auth::id()
                );
                $new_requirement = CompanyRequirement::create($requirement_array);
                if($new_requirement){
                    $system_log_array = array(
                        'action_type' => 'Create',
                        'action_description' => env('CREATE_COMPANY_REQUIREMENT_SUCCESS_MESSAGE'),
                        'perform_by' => \Auth::user()->id,
                        'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                        'target_id' => $new_requirement->id,
                        'target_category' => 'Company Requirement',
                        'result' => 'success',
                    );
                }else{
                    $system_log_array = array(
                        'action_type' => 'Create',
                        'action_description' => env('CREATE_COMPANY_REQUIREMENT_FAIL_MESSAGE'),
                        'perform_by' => \Auth::user()->id,
                        'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                        'target_id' => null,
                        'target_category' => 'Company Requirement',
                        'result' => 'failed',
                    );
                }
                SystemLog::create($system_log_array);
            }
        }

        //add new company potentials
        if(!empty($request->input('potential'))){
            foreach($request->input('potential') as $potential){
                $potential_array = array(
                    'company_id' => $company->id,
                    'potential_id' => $potential,
                    'status' => 'Status 1',
                    'created_by' => \Auth::id()
                );
                $new_potential = CompanyPotential::create($potential_array);
                if($new_potential){
                    $system_log_array = array(
                        'action_type' => 'Create',
                        'action_description' => env('CREATE_COMPANY_REQUIREMENT_SUCCESS_MESSAGE'),
                        'perform_by' => \Auth::user()->id,
                        'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                        'target_id' => $new_potential->id,
                        'target_category' => 'Company Requirement',
                        'result' => 'success',
                    );
                }else{
                    $system_log_array = array(
                        'action_type' => 'Create',
                        'action_description' => env('CREATE_COMPANY_REQUIREMENT_FAIL_MESSAGE'),
                        'perform_by' => \Auth::user()->id,
                        'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                        'target_id' => null,
                        'target_category' => 'Company Requirement',
                        'result' => 'failed',
                    );
                }
                SystemLog::create($system_log_array);
            }
        }

        //add new company features
        if(!empty($request->input('feature'))){
            foreach($request->input('feature') as $feature){
                if(!empty($feature['name'])){
                    $feature_array = array(
                        'company_id' => $company->id,
                        'feature' => $feature['name'],
                        'details' => $feature['detail'],
                        'status' => 'Status 1',
                        'created_by' => \Auth::id()
                    );
                    $new_feature = CompanyFeature::create($feature_array);
                    if($new_feature){
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_FEATURE_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $new_feature->id,
                            'target_category' => 'Company Feature',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_FEATURE_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => null,
                            'target_category' => 'Company Feature',
                            'result' => 'failed',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //add new company remarks
        if(!empty($request->input('remarks'))){
            foreach($request->input('remarks') as $remark){
                if(!empty($remark)){
                    $remark_array = array(
                        'company_id' => $company->id,
                        'remarks' => $remark,
                        'status' => 'Status 1',
                        'created_by' => \Auth::id()
                    );
                    $new_remark = CompanyRemark::create($remark_array);
                    if($new_remark){
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_REMARK_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $new_remark->id,
                            'target_category' => 'Company Remark',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_REMARK_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => null,
                            'target_category' => 'Company Remark',
                            'result' => 'failed',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //add new company achievements
        if(!empty($request->input('achievements'))){
            foreach($request->input('achievements') as $achievement){
                if(!empty($achievement['category'])){
                    $achievement_array = array(
                        'company_id' => $company->id,
                        'category_id' => $achievement['category'],
                        'descriptions' => $achievement['descriptions'],
                        'status' => 'Status 1',
                        'created_by' => \Auth::id()
                    );
                    $new_achievement = CompanyAchievement::create($achievement_array);
                    if($new_achievement){
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_ACHIEVEMENT_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $new_achievement->id,
                            'target_category' => 'Company Achievement',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_ACHIEVEMENT_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => null,
                            'target_category' => 'Company Achievement',
                            'result' => 'failed',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //handle company logo file
        if(!empty($request->file('logo'))){
            $destination_path = public_path().sprintf('/uploads/%s/', $company->id);
            if($request->file('logo')->isValid()){
                if(substr($request->file('logo')->getMimeType(), 0, 5) == 'image') {
                    $file_name = $request->file('logo')->getClientOriginalName();
                    if($request->file('logo')->move($destination_path, $file_name)){
                        $company->logo = \URL::asset('uploads/'.$company->id.'/'.$file_name);
                        $company->save();
                    }
                }else{
                    \Session::flash('alert_message', 'Cannot save company logo, only image files are allowed.');
                    return redirect()->back();
                }
            }else{
                \Session::flash('alert_message', 'Invalid logo file.');
                return redirect()->back();
            }
        }

        \Session::flash('success_message', 'Company has been saved successfully.');
        return redirect('/company');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::with('industries','requirements','potentials','features','remarks','achievements','contacts','logistics','services')->find($id);
        $contact_types = Contact::all();

        $company->date_joined = date('d-m-Y', strtotime($company->date_joined));
        $company->date_operation_started = date('d-m-Y', strtotime($company->date_operation_started));

        return view('company.show', compact('company', 'industries', 'requirements', 'potentials', 'achievements', 'contact_types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::with('industries','requirements','potentials','features','remarks','achievements','contacts','logistics','services')->find($id);

        $selected_industries = array();
        $selected_requirements = array();
        $selected_potentials = array();
        $selected_logistics = array();
        $selected_services = array();

        if(!empty($company->industries)){
            foreach($company->industries as $industry){
                $selected_industries[] = $industry['id'];
            }
        }

        if(!empty($company->requirements)){
            foreach($company->requirements as $requirement){
                $selected_requirements[] = $requirement['id'];
            }
        }

        if(!empty($company->potentials)){
            foreach($company->potentials as $potential){
                $selected_potentials[] = $potential['id'];
            }
        }

        if(!empty($company->logistics)){
            foreach($company->logistics as $logistic){
                $selected_logistics[] = $logistic['id'];
            }
        }

        if(!empty($company->services)){
            foreach($company->services as $service){
                $selected_services[] = $service['id'];
            }
        }

        $company->date_joined = date('d-m-Y', strtotime($company->date_joined));
        $company->date_operation_started = date('d-m-Y', strtotime($company->date_operation_started));

        $industries = Industry::all();
        $requirements = Requirement::all();
        $potentials = Potential::all();
        $achievements = Achievement::all();
        $logistics = Logistic::all();
        $services = Service::all();
        $contact_types = Contact::all();

        return view('company.edit', compact('company', 'selected_industries', 'selected_requirements', 'selected_potentials', 'industries', 'requirements', 'potentials', 'achievements', 'contact_types', 'selected_logistics', 'selected_services', 'logistics', 'services'));
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
        $company = Company::with('industries','requirements','potentials','features','remarks','logistics','services')->find($id);

        $refined_joined_date = date('Y-m-d', strtotime($request->input('joined_date')));
        $refined_operation_date = date('Y-m-d', strtotime($request->input('operation_date')));

        if($request->input('gst') == 0){
            $gst_percent = 0;
        }else{
            $gst_percent = $request->input('gst_percent');
        }

        $company_array = array(
            'company_name' => $request->input('company_name'),
            'category' => $request->input('category'),
            'date_joined' => $refined_joined_date,
            'date_operation_started' => $refined_operation_date,
            'registration_num' => $request->input('registration_num'),
            'paid_up_capital' => $request->input('paid_up_capital'),
            'no_of_employees' => $request->input('no_of_employees'),
            'annual_turnover' => $request->input('annual_turnover'),
            'keyword' => $request->input('keyword'),
            'physical_file_number' => $request->input('physical_file_number'),
            'billing_period' => $request->input('billing_period'),
            'include_gst' => $request->input('gst'),
            'gst_percent' => $gst_percent,
            'status' => $request->input('status'),
            'account_quota' => $request->input('account_quota'),
            'modified_by' => \Auth::id()
        );
        $company->fill($company_array);
        if($company->save()){
            $system_log_array = array(
                'action_type' => 'Update',
                'action_description' => env('UPDATE_COMPANY_PROFILE_SUCCESS_MESSAGE'),
                'perform_by' => \Auth::id(),
                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                'target_id' => $company->id,
                'target_category' => 'Company',
                'result' => 'success',
            );
        }else{
            $system_log_array = array(
                'action_type' => 'Update',
                'action_description' => env('UPDATE_COMPANY_PROFILE_FAIL_MESSAGE'),
                'perform_by' => \Auth::id(),
                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                'target_id' => $company->id,
                'target_category' => 'Company',
                'result' => 'failed',
            );
        }
        SystemLog::create($system_log_array);

        //handle company logistic and service
        if($request->input('category') == 'LSP'){
            //handle company logistics for LSP
            $previous_logistic_name_list = array();
            if(!empty($company->logistics)){
                foreach($company->logistics as $previous_logistic_key => $previous_logistic){
                    $previous_logistic_name_list[$previous_logistic['pivot']['id']] = $previous_logistic['id'];
                }
            }

            $delete_logistics_different = array_diff($previous_logistic_name_list, $request->input('logistic'));
            $new_logistics_different = array_diff($request->input('logistic'), $previous_logistic_name_list);

            if(!empty($delete_logistics_different)){
                foreach($delete_logistics_different as $delete_logistic_key => $delete_logistic){
                    $logistic = CompanyLogistic::find($delete_logistic_key);
                    if($logistic){
                        if($logistic->delete()){
                            $system_log_array = array(
                                'action_type' => 'Delete',
                                'action_description' => env('DELETE_COMPANY_LOGISTIC_MESSAGE'),
                                'perform_by' => \Auth::id(),
                                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                                'target_id' => $delete_logistic_key,
                                'target_category' => 'Company Logistic',
                                'result' => 'success',
                            );
                            SystemLog::create($system_log_array);
                        }
                    }
                }
            }

            if(!empty($new_logistics_different)){
                foreach($new_logistics_different as $new_logistic){
                    $logistic_array = array(
                        'company_id' => $company->id,
                        'logistic_id' => $new_logistic,
                        'status' => 'Status 1',
                        'created_by' => \Auth::id()
                    );
                    $new_add_logistic = CompanyLogistic::create($logistic_array);
                    if($new_add_logistic){
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_LOGISTIC_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $new_add_logistic->id,
                            'target_category' => 'Company Logistic',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_LOGISTIC_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => null,
                            'target_category' => 'Company Logistic',
                            'result' => 'failed',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }

            //handle company services for LSP
            $previous_services_name_list = array();
            if(!empty($company->services)){
                foreach($company->services as $previous_service_key => $previous_service){
                    $previous_services_name_list[$previous_service_key['pivot']['id']] = $previous_service['id'];
                }
            }

            $delete_services_different = array_diff($previous_services_name_list, $request->input('service'));
            $new_services_different = array_diff($request->input('service'), $previous_services_name_list);

            if(!empty($delete_services_different)){
                foreach($delete_services_different as $delete_service_key => $delete_service){
                    $service = CompanyService::find($delete_service_key);
                    if($service){
                        if($service->delete()){
                            $system_log_array = array(
                                'action_type' => 'Delete',
                                'action_description' => env('DELETE_COMPANY_SERVICE_MESSAGE'),
                                'perform_by' => \Auth::id(),
                                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                                'target_id' => $delete_service_key,
                                'target_category' => 'Company Service',
                                'result' => 'success',
                            );
                            SystemLog::create($system_log_array);
                        }
                    }
                }
            }

            if(!empty($new_services_different)){
                foreach($new_services_different as $new_service){
                    $service_array = array(
                        'company_id' => $company->id,
                        'service_id' => $new_service,
                        'status' => 'Status 1',
                        'created_by' => \Auth::id()
                    );
                    $new_add_service = CompanyService::create($service_array);
                    if($new_add_service){
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_SERVICE_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $new_add_service->id,
                            'target_category' => 'Company Service',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_SERVICE_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => null,
                            'target_category' => 'Company Service',
                            'result' => 'failed',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //handle company industry
        if(!empty($request->input('industry'))){
            $previous_industry_name_list = array();
            if(!empty($company->industries)){
                foreach($company->industries as $previous_industry_key => $previous_industry){
                    $previous_industry_name_list[$previous_industry['pivot']['id']] = $previous_industry['id'];
                }
            }

            $delete_industries_different = array_diff($previous_industry_name_list, $request->input('industry'));
            $new_industries_different = array_diff($request->input('industry'), $previous_industry_name_list);

            if(!empty($delete_industries_different)){
                foreach($delete_industries_different as $delete_industry_key => $delete_industry){
                    $industry = CompanyIndustry::find($delete_industry_key);
                    if($industry){
                        if($industry->delete()){
                            $system_log_array = array(
                                'action_type' => 'Delete',
                                'action_description' => env('DELETE_COMPANY_INDUSTRY_MESSAGE'),
                                'perform_by' => \Auth::id(),
                                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                                'target_id' => $delete_industry_key,
                                'target_category' => 'Company Industry',
                                'result' => 'success',
                            );
                            SystemLog::create($system_log_array);
                        }
                    }
                }
            }

            if(!empty($new_industries_different)){
                foreach($new_industries_different as $new_industry){
                    $industry_array = array(
                        'company_id' => $company->id,
                        'industry_id' => $new_industry,
                        'status' => 'Status 1',
                        'created_by' => \Auth::id()
                    );
                    $new_add_industry = CompanyIndustry::create($industry_array);
                    if($new_add_industry){
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_INDUSTRY_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $new_add_industry->id,
                            'target_category' => 'Company Industry',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_INDUSTRY_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => null,
                            'target_category' => 'Company Industry',
                            'result' => 'failed',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //handle company requirements
        if(!empty($request->input('requirement'))){
            $previous_requirement_name_list = array();
            if(!empty($company->requirements)){
                foreach($company->requirements as $previous_requirement){
                    $previous_requirement_name_list[$previous_requirement['pivot']['id']] = $previous_requirement['id'];
                }
            }

            $delete_requirements_different = array_diff($previous_requirement_name_list, $request->input('requirement'));
            $new_requirements_different = array_diff($request->input('requirement'), $previous_requirement_name_list);

            if(!empty($delete_requirements_different)){
                foreach($delete_requirements_different as $delete_requirement_key => $delete_requirement){
                    $requirement = CompanyRequirement::find($delete_requirement_key);
                    if($requirement){
                        if($requirement->delete()){
                            $system_log_array = array(
                                'action_type' => 'Delete',
                                'action_description' => env('DELETE_COMPANY_REQUIREMENT_MESSAGE'),
                                'perform_by' => \Auth::id(),
                                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                                'target_id' => $delete_requirement_key,
                                'target_category' => 'Company Requirement',
                                'result' => 'success',
                            );
                            SystemLog::create($system_log_array);
                        }
                    }
                }
            }

            if(!empty($new_requirements_different)){
                foreach($new_requirements_different as $new_requirement){
                    $requirement_array = array(
                        'company_id' => $company->id,
                        'requirement_id' => $new_requirement,
                        'status' => 'Status 1',
                        'created_by' => \Auth::id()
                    );
                    $new_add_requirement = CompanyRequirement::create($requirement_array);
                    if($new_add_requirement){
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_REQUIREMENT_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $new_add_requirement->id,
                            'target_category' => 'Company Requirement',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_REQUIREMENT_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => null,
                            'target_category' => 'Company Requirement',
                            'result' => 'failed',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //handle potentials
        if(!empty($request->input('potential'))){
            $previous_potential_name_list = array();
            if(!empty($company->potentials)){
                foreach($company->potentials as $previous_potential){
                    $previous_potential_name_list[$previous_potential['pivot']['id']] = $previous_potential['id'];
                }
            }

            $delete_potentials_different = array_diff($previous_potential_name_list, $request->input('potential'));
            $new_potentials_different = array_diff($request->input('potential'), $previous_potential_name_list);

            if(!empty($delete_potentials_different)){
                foreach($delete_potentials_different as $delete_potential_key => $delete_potential){
                    $potential = CompanyPotential::find($delete_potential_key);
                    if($potential){
                        if($potential->delete()){
                            $system_log_array = array(
                                'action_type' => 'Delete',
                                'action_description' => env('DELETE_COMPANY_POTENTIAL_MESSAGE'),
                                'perform_by' => \Auth::id(),
                                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                                'target_id' => $delete_potential_key,
                                'target_category' => 'Company Potential',
                                'result' => 'success',
                            );
                            SystemLog::create($system_log_array);
                        }
                    }
                }
            }

            if(!empty($new_potentials_different)){
                foreach($new_potentials_different as $new_potential){
                    $potential_array = array(
                        'company_id' => $company->id,
                        'potential_id' => $new_potential,
                        'status' => 'Status 1',
                        'created_by' => \Auth::id()
                    );
                    $new_add_potential = CompanyPotential::create($potential_array);
                    if($new_add_potential){
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_POTENTIAL_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $new_add_potential->id,
                            'target_category' => 'Company Potential',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_POTENTIAL_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => null,
                            'target_category' => 'Company Potential',
                            'result' => 'failed',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //handle remarks
        if(!empty($request->input('previous_remarks'))){
            foreach($request->input('previous_remarks') as $previous_remark_edit_key => $previous_remark_edit){
                $previous_remark = CompanyRemark::find($previous_remark_edit_key);
                if($previous_remark['remarks'] != $previous_remark_edit){
                    $previous_remark->remarks = $previous_remark_edit;
                    $previous_remark->modified_by = \Auth::id();
                    if($previous_remark->save()){
                        $system_log_array = array(
                            'action_type' => 'Update',
                            'action_description' => env('UPDATE_COMPANY_REMARK_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $previous_remark_edit_key,
                            'target_category' => 'Company Remark',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Update',
                            'action_description' => env('UPDATE_COMPANY_REMARK_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $previous_remark_edit_key,
                            'target_category' => 'Company Remark',
                            'result' => 'fail',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //handle new remarks
        if(!empty($request->input('remarks'))){
            foreach($request->input('remarks') as $remark){
                if(!empty($remark)){
                    $remark_array = array(
                        'company_id' => $company->id,
                        'remarks' => $remark,
                        'status' => 'Status 1',
                        'created_by' => \Auth::id()
                    );
                    $new_add_remark = CompanyRemark::create($remark_array);
                    if($new_add_remark){
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_REMARK_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $new_add_remark->id,
                            'target_category' => 'Company Remark',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_REMARK_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => null,
                            'target_category' => 'Company Remark',
                            'result' => 'failed',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //handle old company features
        if(!empty($request->input('previous_feature'))){
            foreach($request->input('previous_feature') as $previous_feature_edit_key => $previous_feature_edit){
                $previous_feature = CompanyFeature::find($previous_feature_edit_key);
                if($previous_feature['feature'] != $previous_feature_edit['name'] || $previous_feature['details'] != $previous_feature_edit['detail']){
                    $previous_feature->feature = $previous_feature_edit['name'];
                    $previous_feature->details = $previous_feature_edit['detail'];
                    $previous_feature->modified_by = \Auth::id();
                    if($previous_feature->save()){
                        $system_log_array = array(
                            'action_type' => 'Update',
                            'action_description' => env('UPDATE_COMPANY_FEATURE_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $previous_feature_edit_key,
                            'target_category' => 'Company Feature',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Update',
                            'action_description' => env('UPDATE_COMPANY_FEATURE_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $previous_feature_edit_key,
                            'target_category' => 'Company Feature',
                            'result' => 'fail',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //handle new feature
        if(!empty($request->input('feature'))){
            foreach($request->input('feature') as $feature){
                if(!empty($feature['name']) || !empty($feature['detail'])){
                    $feature_array = array(
                        'company_id' => $company->id,
                        'feature' => $feature['name'],
                        'details' => $feature['detail'],
                        'status' => 'Status 1',
                        'created_by' => \Auth::id()
                    );
                    $new_add_feature = CompanyFeature::create($feature_array);
                    if($new_add_feature){
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_FEATURE_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $new_add_feature->id,
                            'target_category' => 'Company Feature',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_FEATURE_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => null,
                            'target_category' => 'Company Feature',
                            'result' => 'failed',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //handle old company achievement
        if(!empty($request->input('previous_achievements'))){
            foreach($request->input('previous_achievements') as $previous_achievement_edit_key => $previous_achievement_edit){
                $previous_achievement = CompanyAchievement::find($previous_achievement_edit_key);
                if($previous_achievement['category_id'] != $previous_achievement_edit['category'] || $previous_achievement['descriptions'] != $previous_achievement_edit['descriptions']){
                    $previous_achievement->category_id = $previous_achievement_edit['category'];
                    $previous_achievement->descriptions = $previous_achievement_edit['descriptions'];
                    $previous_achievement->modified_by = \Auth::id();
                    if($previous_achievement->save()){
                        $system_log_array = array(
                            'action_type' => 'Update',
                            'action_description' => env('UPDATE_COMPANY_FEATURE_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $previous_achievement_edit_key,
                            'target_category' => 'Company Feature',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Update',
                            'action_description' => env('UPDATE_COMPANY_FEATURE_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $previous_achievement_edit_key,
                            'target_category' => 'Company Feature',
                            'result' => 'fail',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //handle new achievement
        if(!empty($request->input('achievements'))){
            foreach($request->input('achievements') as $achievement){
                if(!empty($achievement['category'])){
                    $achievement_array = array(
                        'company_id' => $company->id,
                        'category_id' => $achievement['category'],
                        'descriptions' => $achievement['descriptions'],
                        'status' => 'Status 1',
                        'created_by' => \Auth::id()
                    );
                    $new_add_achievement = CompanyAchievement::create($achievement_array);
                    if($new_add_achievement){
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_ACHIEVEMENT_SUCCESS_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => $new_add_achievement->id,
                            'target_category' => 'Company Achievement',
                            'result' => 'success',
                        );
                    }else{
                        $system_log_array = array(
                            'action_type' => 'Create',
                            'action_description' => env('CREATE_COMPANY_ACHIEVEMENT_FAIL_MESSAGE'),
                            'perform_by' => \Auth::id(),
                            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                            'target_id' => null,
                            'target_category' => 'Company Achievement',
                            'result' => 'failed',
                        );
                    }
                    SystemLog::create($system_log_array);
                }
            }
        }

        //handle company logo file
        if($request->file('logo')){
            $destination_path = public_path().sprintf('/uploads/%s/', $company->id);
            if($request->file('logo')->isValid()){
                if(substr($request->file('logo')->getMimeType(), 0, 5) == 'image') {
                    $old_logo_file_path = null;
                    if(!empty($company->logo)){
                        $old_logo_file_path = $company->logo;
                    }
                    $file_name = $request->file('logo')->getClientOriginalName();
                    if($request->file('logo')->move($destination_path, $file_name)){
                        $company->logo = \URL::asset('uploads/'.$company->id.'/'.$file_name);
                        if($company->save()){
                            if($old_logo_file_path != null){
                                $split_file_path = explode('/', $old_logo_file_path);
                                $file_name = $split_file_path[count($split_file_path)-1];
                                $old_file_path= public_path().'/uploads/'.$company->id.'/'.$file_name;
                                \File::delete($old_file_path);
                            }
                        }
                    }
                }else{
                    \Session::flash('alert_message', 'Cannot save company logo, only image files are allowed.');
                    return redirect()->back()->withInput();
                }
            }else{
                \Session::flash('alert_message', 'Invalid logo file.');
                return redirect()->back()->withInput();
            }
        }

        \Session::flash('success_message', 'Company has been updated successfully.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete = 1;
        $company->save();

        \Session::flash('success_message', 'Company has been deleted successfully.');
        return redirect('/company');
    }

    public function generateCompanyList($type){
        $companies = null;
        if($type == 'inward_group_admin' || $type == 'inward_group_user'){
            $companies = Company::where('category', 'LSP')->where('delete', '0')->get();
        }elseif($type == 'outward_group_admin' || $type == 'outward_group_user'){
            $companies = Company::where('category', 'Outsourcing')->where('delete', '0')->get();
        }

        return view('company.generate_company_list', compact('companies'));
    }

    /**
     * Manage company files.
     */
    public function manageCompanyFiles($id)
    {
        $company = Company::with('files')->findOrFail($id);

        //put files into different categories
        $invoice_files = array();
        $dn_files = array();
        $cn_files = array();
        $logo_files = array();
        $profile_files = array();
        $support_files = array();
        $registration_files = array();
        $others_files = array();
        if(!empty($company->files)){
            foreach($company->files as $file){
                switch ($file->file_type) {
                    case 'Invoice':
                        $invoice_files[] = $file;
                        break;
                    case 'DN':
                        $dn_files[] = $file;
                        break;
                    case 'CN':
                        $cn_files[] = $file;
                        break;
                    case 'Logo':
                        $logo_files[] = $file;
                        break;
                    case 'Profile':
                        $profile_files[] = $file;
                        break;
                    case 'Support':
                        $support_files[] = $file;
                        break;
                    case 'Registration':
                        $registration_files[] = $file;
                        break;
                    case 'Others':
                        $others_files[] = $file;
                        break;
                }
            }
        }

        return view('company.manage_company_file', compact('company', 'invoice_files', 'dn_files', 'cn_files', 'logo_files', 'profile_files', 'support_files', 'registration_files', 'others_files'));
    }

    /**
     * Save company files.
     */
    public function saveCompanyFile(Request $request, $id)
    {
        if($request->file('file')){
            $destination_path = public_path().sprintf('/uploads/%s/', $id);
            if($request->file('file')->isValid()){
                $file_name = $request->file('file')->getClientOriginalName();
                if($request->file('file')->move($destination_path, $file_name)){
                    $file_array = array(
                        'company_id' => $id,
                        'file_name' => $request->input('file_name'),
                        'file_path' => \URL::asset('uploads/'.$id.'/'.$file_name),
                        'file_type' => $request->input('file_type'),
                        'status' => 'Active',
                        'created_by' => \Auth::id()
                    );

                    if(CompanyFile::create($file_array)){
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

        return redirect('/company/manage_company_files/'.$id);
    }

    /**
     * remove company files.
     */
    public function deleteCompanyFile($file_id, $company_id)
    {
        $company_file = CompanyFile::findOrFail($file_id);
        $status = false;

        $split_file_path = explode('/', $company_file->file_path);
        $file_name = $split_file_path[count($split_file_path)-1];
        $old_file_path= public_path().'/uploads/'.$company_id.'/'.$file_name;

        if(\File::delete($old_file_path) && $company_file->delete()){
            $status = true;
        }

        return response()->json(['status' => $status]);
    }

    public function deleteCompanyFeature($id){
        $company_feature = CompanyFeature::findOrFail($id);
        $status = false;
        if($company_feature->delete()){
            $status = true;
        }

        return response()->json(['status' => $status]);
    }

    public function deleteCompanyRemark($id){
        $company_remark = CompanyRemark::findOrFail($id);
        $status = false;
        if($company_remark->delete()){
            $status = true;
        }

        return response()->json(['status' => $status]);
    }

    public function deleteCompanyAchievement($id){
        $company_achievement = CompanyAchievement::findOrFail($id);
        $status = false;
        if($company_achievement->delete()){
            $status = true;
        }

        return response()->json(['status' => $status]);
    }

    public function editCompanyContact(Request $request, $id){
        $company_contact = CompanyContact::findOrFail($id);
        $update_company_contact_array = array(
            'contact_type_id' => $request->input('contact_type'),
            'address_line_1' => $request->input('address_line_1'),
            'address_line_2' => $request->input('address_line_2'),
            'address_line_3' => $request->input('address_line_3'),
            'postcode' => $request->input('postcode'),
            'town' => $request->input('town'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'tel_num' => $request->input('tel_num'),
            'fax_num' => $request->input('fax_num'),
            'website' => $request->input('website'),
            'pic_name' => $request->input('pic_name'),
            'pic_department' => $request->input('pic_department'),
            'pic_designation' => $request->input('pic_designation'),
            'pic_mobile_num' => $request->input('pic_mobile_num'),
            'pic_email_1' => $request->input('pic_email_1'),
            'pic_email_2' => $request->input('pic_email_2'),
            'modified_by' => \Auth::id()
        );
        $company_contact->fill($update_company_contact_array);
        if($company_contact->save()){
            \Session::flash('success_message', 'Company contact has been updated successfully.');
        }else{
            \Session::flash('alert_message', 'Company contact cannot be updated.');
        }
        return redirect()->back();
    }

    public function deleteCompanyContact($id){
        $company_contact = CompanyContact::findOrFail($id);
        $status = false;
        if($company_contact->delete()){
            $status = true;
        }

        return response()->json(['status' => $status]);
    }

    public function addCompanyContact(Request $request, $id){
        $new_company_contact_array = array(
            'company_id' => $id,
            'contact_type_id' => $request->input('new_contact_contact_type'),
            'address_line_1' => $request->input('new_contact_address_line_1'),
            'address_line_2' => $request->input('new_contact_address_line_2'),
            'address_line_3' => $request->input('new_contact_address_line_3'),
            'postcode' => $request->input('new_contact_postcode'),
            'town' => $request->input('new_contact_town'),
            'state' => $request->input('new_contact_state'),
            'country' => $request->input('new_contact_country'),
            'tel_num' => $request->input('new_contact_tel_num'),
            'fax_num' => $request->input('new_contact_fax_num'),
            'website' => $request->input('new_contact_website'),
            'pic_name' => $request->input('new_contact_pic_name'),
            'pic_department' => $request->input('new_contact_pic_department'),
            'pic_designation' => $request->input('new_contact_pic_designation'),
            'pic_mobile_num' => $request->input('new_contact_pic_mobile_num'),
            'pic_email_1' => $request->input('new_contact_pic_email_1'),
            'pic_email_2' => $request->input('new_contact_pic_email_2'),
            'created_by' => \Auth::id()
        );

        if(CompanyContact::create($new_company_contact_array)){
            \Session::flash('success_message', 'Company contact has been saved successfully.');
            return redirect()->back();
        }else{
            \Session::flash('alert_message', 'Company contact cannot be saved.');
            return redirect()->back()->withInput();
        }
    }

    public function history($id){
        $company = Company::with('jobs.rfi_status')->with('bids.rfi_status')->find($id);

        return view('company.history', compact('company'));
    }
}