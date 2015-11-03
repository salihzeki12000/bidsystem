<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Company;
use Validator;
use App\SystemLog;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest('updated_at')->with('company')->where('delete', 0)->get();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::get();
        return view('user.create', compact('companies'));
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    protected function validatorForEdit(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'confirmed|min:6',
        ]);
    }

    protected function validatorForEditByNormalUser(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'password' => 'confirmed|min:6',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        if($request->type == 'globe_admin'){
            $user_array = array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => $request->type,
                'status' => $request->status,
                'company_id' => null
            );
            if(User::create($user_array)){
                \Session::flash('success_message', 'User has been saved successfully.');
                return redirect('/user');
            }else{
                \Session::flash('alert_message', 'User cannot be saved.');
                return redirect()->back()->withInput();
            }
        }else{
            $company = Company::findOrFail($request->company_id);
            $number_of_current_users = User::where('company_id', $request->company_id)->count();
            if($company->account_quota > $number_of_current_users){
                $user_array = array(
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'type' => $request->type,
                    'status' => $request->status,
                    'company_id' => $request->company_id
                );
                if(User::create($user_array)){
                    \Session::flash('success_message', 'User has been saved successfully.');
                    return redirect('/user');
                }else{
                    return redirect()->back()->withInput();
                }
            }else{
                \Session::flash('alert_message', 'Cannot add user to this company, because the company runs out of its account quota.');
                return redirect()->back()->withInput();
            }
        }
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
        $user = User::findOrFail($id);
        if($user->type == 'inward_group_admin' || $user->type == 'inward_group_user'){
            $companies = Company::where('category', 'LSP')->get();
        }elseif($user->type == 'outward_group_admin' || $user->type == 'outward_group_user'){
            $companies = Company::where('category', 'Outsourcing')->get();
        }else{
            $companies = Company::get();
        }

        return view('user.edit', compact('user', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validatorForEdit($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = User::findOrFail($id);

        if($request->password){
            $user_array = array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => $request->type,
                'status' => $request->status,
                'company_id' => $request->company_id
            );
        }else{
            $user_array = array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'type' => $request->type,
                'status' => $request->status,
                'company_id' => $request->company_id
            );
        }

        if($user_array['type'] == 'globe_admin'){
            $user_array['company_id'] = null;
        }
        $user->fill($user_array);

        \Session::flash('success_message', 'User has been updated successfully.');
        if($user->save()){
            $system_log_array = array(
                'action_type' => 'Update',
                'action_description' => env('UPDATE_USER_SUCCESS_MESSAGE'),
                'perform_by' => \Auth::user()->id,
                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                'target_id' => $id,
                'target_category' => 'User',
                'result' => 'success',
            );
            SystemLog::create($system_log_array);
            return redirect()->back();
        }else{
            $system_log_array = array(
                'action_type' => 'Update',
                'action_description' => env('UPDATE_USER_FAIL_MESSAGE'),
                'perform_by' => \Auth::user()->id,
                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                'target_id' => $id,
                'target_category' => 'User',
                'result' => 'fail',
            );
            SystemLog::create($system_log_array);
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete = 1;
        if($user->save()){
            $system_log_array = array(
                'action_type' => 'Delete',
                'action_description' => env('DELETE_USER_SUCCESS_MESSAGE'),
                'perform_by' => \Auth::user()->id,
                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                'target_id' => $id,
                'target_category' => 'User',
                'result' => 'success',
            );
        }else{
            $system_log_array = array(
                'action_type' => 'Delete',
                'action_description' => env('DELETE_USER_FAIL_MESSAGE'),
                'perform_by' => \Auth::user()->id,
                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                'target_id' => $id,
                'target_category' => 'User',
                'result' => 'failed',
            );
        }
        SystemLog::create($system_log_array);

        \Session::flash('success_message', 'User has been deleted successfully.');
        return redirect()->back();
    }

    /**
     * Display user profile page for normal user.
     */
    public function editByNormalUser($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit_by_normal_user', compact('user'));
    }

    /**
     * Update user profile by user themself.
     */
    public function updateByNormalUser(Request $request, $id)
    {
        $validator = $this->validatorForEditByNormalUser($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = User::findOrFail($id);

        if($request->password){
            $user_array = array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => bcrypt($request->password)
            );
        }else{
            $user_array = array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            );
        }
        $user->fill($user_array);

        if($user->save()){
            \Session::flash('success_message', 'User has been updated successfully.');
            $system_log_array = array(
                'action_type' => 'Update',
                'action_description' => env('UPDATE_USER_SUCCESS_MESSAGE'),
                'perform_by' => \Auth::user()->id,
                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                'target_id' => $id,
                'target_category' => 'User',
                'result' => 'success',
            );
            SystemLog::create($system_log_array);
            return redirect()->back();
        }else{
            $system_log_array = array(
                'action_type' => 'Update',
                'action_description' => env('UPDATE_USER_FAIL_MESSAGE'),
                'perform_by' => \Auth::user()->id,
                'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
                'target_id' => $id,
                'target_category' => 'User',
                'result' => 'fail',
            );
            SystemLog::create($system_log_array);
            return redirect()->back()->withInput();
        }
    }

    /**
     * manage group user
     */
    public function manageGroupUser()
    {
//        if(\Auth::user()->type != 'inward_group_admin' || \Auth::user()->type != 'outward_group_admin'){
//            \Session::flash('success_message', "Only group admin can access this page.");
//            return redirect('/home');
//        }

        $company = Company::find(\Auth::user()->company_id);
        $users = User::where('company_id', \Auth::user()->company_id)->where('delete', 0)->get();
        return view('user.manage_group_user', compact('users', 'company'));
    }

    /**
     * add group user
     */
    public function addGroupUser(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $company = Company::findOrFail($request->company_id);
        if($company->account_quota > $request->company_quota){
            if($company->category == 'LSP'){
                $user_type = 'outward_group_user';
            }else{
                $user_type = 'inward_group_user';
            }

            $user_array = array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => $user_type,
                'status' => $request->status,
                'company_id' => $request->company_id
            );
            if(User::create($user_array)){
                \Session::flash('success_message', 'User has been saved successfully.');
                return redirect('/manage_group_user');
            }else{
                return redirect()->back()->withInput();
            }
        }else{
            \Session::flash('alert_message', 'Cannot add user to this company, because the company runs out of its account quota.');
            return redirect()->back()->withInput();
        }

    }
}