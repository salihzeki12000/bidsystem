<?php

namespace App\Http\Controllers;

use App\RfiState;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bid;
use App\BidFile;
use App\Job;
use App\Company;
use App\FileType;
use App\CompanyTransaction;

class BidsController extends Controller
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
        $bids = Bid::where('delete', '!=', 1)->with('company')->with('job')->with('rfi_status')->get();

        return view('bid.index', compact('bids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Bid::class);

        if(\Auth::user()->company_id){
            if(!$this->checkCreditStatus(\Auth::user()->company_id)){
                \Session::flash('alert_message', "Sorry, your credit may has been expired or not sufficient to create new job, please contact system admin to top-up credit.");
                return redirect()->back();
            }

            $company = Company::findOrFail(\Auth::user()->company_id);
        }

        $jobs = Job::where('delete', '!=', 1)->lists('id');

        if(\Auth::user()->type == 'super_admin' || \Auth::user()->type == 'globe_admin'){
            $companies = Company::where('category', 'LSP')->where('delete', '0')->get();
        }

        return view('bid.create', compact('jobs', 'companies', 'company'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Bid::class);
        //var_dump($request->all());
        $status = 7;

        if($request->button){
            if($request->button == 'Save as draft'){
                $status = 1;
            }
        }

        $refined_date_date = date('Y-m-d', strtotime($request->input('date')));
        $refined_rfp_date = date('Y-m-d H:i', strtotime($request->input('rfp_submission_date')));
        $refined_rfq_date = date('Y-m-d H:i', strtotime($request->input('rfq_submission_date')));
        $refined_first_meeting_target_date = date('Y-m-d H:i', strtotime($request->input('first_meeting_target_date')));
        $refined_closure_target_date = date('Y-m-d H:i', strtotime($request->input('closure_target_date')));

        $company_id = null;
        if(\Auth::user()->type == 'super_admin' || \Auth::user()->type == 'globe_admin'){
            $company_id = $request->admin_company;
        }else{
            $company_id = $request->company_id;
        }

        $company = Company::find($company_id);

        $bid_array = array(
            'job_id' => $request->job,
            'company_id' => $company_id,
            'date' => $refined_date_date,
            'est_budget' => $request->est_budget,
            'additional_description' => $request->description,
            'reply_to_special_request' => $request->reply_special_request,
            'status_id' => $status,
            'sales_pic' => $request->sales_pic,
            'rfp_submission_date' => $refined_rfp_date,
            'rfq_submission_date' => $refined_rfq_date,
            'first_meeting_target_date' => $refined_first_meeting_target_date,
            'closure_target_date' => $refined_closure_target_date,
            'created_by' => \Auth::id()
        );

        $new_bid = Bid::create($bid_array);
        if($new_bid){
            $company_transaction_array = array(
                'company_id' => $company_id,
                'amount' => $company->credit_unit_cost,
                'type' => 'bid',
                'item_id' => $new_bid->id,
                'created_by' => \Auth::id()
            );
            $new_company_transaction = CompanyTransaction::create($company_transaction_array);

            $company->credit_amount = $company->credit_amount - $company->credit_unit_cost;
            $company->save();

            \Session::flash('success_message', 'Bid has been saved successfully.');
            return redirect('/bid/manage_bid_files/'.$new_bid->id);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bid = Bid::with('company')->with('rfi_status')->find($id);
        $job = Job::find($bid->job_id);

        if (\Auth::user()->company_id != $job->company_id && \Auth::user()->company_id != $bid->company_id) {
            abort('403');
        }

        $rfi_status = RfiState::where('available_for_bid_outsourcer', 1)->lists('rfi_status', 'id');

        $new_date = strtotime($bid->date);
        $bid->date = date('d-m-Y', $new_date);

        $rfp_date = strtotime($bid->rfp_submission_date);
        $bid->rfp_submission_date = date('d-m-Y H:i', $rfp_date);

        $rfq_date = strtotime($bid->rfq_submission_date);
        $bid->rfq_submission_date = date('d-m-Y H:i', $rfq_date);

        $new_first_meeting_target_date = strtotime($bid->first_meeting_target_date);
        $bid->first_meeting_target_date = date('d-m-Y H:i', $new_first_meeting_target_date);

        $new_closure_target_date = strtotime($bid->closure_target_date);
        $bid->closure_target_date = date('d-m-Y H:i', $new_closure_target_date);

        return view('bid.show', compact('bid', 'rfi_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bid = Bid::with('company')->with('rfi_status')->find($id);

        $this->authorize('ownership', $bid);

        $jobs = Job::where('delete', '!=', 1)->lists('id');
        $status = RfiState::where('available_for_bid_lsp', 1)->get();

        if(\Auth::user()->type == 'super_admin' || \Auth::user()->type == 'globe_admin'){
            $companies = Company::where('category', 'LSP')->where('delete', '0')->get();
        }

        $new_date = strtotime($bid->date);
        $bid->date = date('d-m-Y', $new_date);

        $rfp_date = strtotime($bid->rfp_submission_date);
        $bid->rfp_submission_date = date('d-m-Y H:i', $rfp_date);

        $rfq_date = strtotime($bid->rfq_submission_date);
        $bid->rfq_submission_date = date('d-m-Y H:i', $rfq_date);

        $new_first_meeting_target_date = strtotime($bid->first_meeting_target_date);
        $bid->first_meeting_target_date = date('d-m-Y H:i', $new_first_meeting_target_date);

        $new_closure_target_date = strtotime($bid->closure_target_date);
        $bid->closure_target_date = date('d-m-Y H:i', $new_closure_target_date);

        return view('bid.edit', compact('bid', 'jobs', 'companies', 'status'));
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
        //var_dump($request->all());

        $bid = Bid::find($id);

        $this->authorize('ownership', $bid);

        $refined_date_date = date('Y-m-d', strtotime($request->input('date')));
        $refined_rfp_date = date('Y-m-d H:i', strtotime($request->input('rfp_submission_date')));
        $refined_rfq_date = date('Y-m-d H:i', strtotime($request->input('rfq_submission_date')));
        $refined_first_meeting_target_date = date('Y-m-d H:i', strtotime($request->input('first_meeting_target_date')));
        $refined_closure_target_date = date('Y-m-d H:i', strtotime($request->input('closure_target_date')));

        $company_id = null;
        if(\Auth::user()->type == 'super_admin' || \Auth::user()->type == 'globe_admin'){
            $company_id = $request->admin_company;
        }else{
            $company_id = $request->company_id;
        }

        $bid_array = array(
            'job_id' => $request->job,
            'company_id' => $company_id,
            'date' => $refined_date_date,
            'est_budget' => $request->est_budget,
            'additional_description' => $request->description,
            'reply_to_special_request' => $request->reply_special_request,
            'status_id' => $request->status,
            'sales_pic' => $request->sales_pic,
            'rfp_submission_date' => $refined_rfp_date,
            'rfq_submission_date' => $refined_rfq_date,
            'first_meeting_target_date' => $refined_first_meeting_target_date,
            'closure_target_date' => $refined_closure_target_date,
            'modified_by' => \Auth::id()
        );

        $bid->fill($bid_array);
        if($bid->save()){
            \Session::flash('success_message', 'Bid has been updated successfully.');
        }else{
            \Session::flash('alert_message', 'Bid cannot be updated.');
        }

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
        $this->authorize('delete', Bid::class);
        $bid = Bid::findOrFail($id);
        $bid->delete = 1;
        $bid->save();

        \Session::flash('success_message', 'Bid has been deleted successfully.');
        return redirect('/bid');
    }

    public function showForOutsourcer($id){

    }

    public function manageBidFiles($id){
        $bid = Bid::with('files')->findOrFail($id);

        $this->authorize('ownership', $bid);
        if(\Auth::user()->company_id){
            $company = Company::findOrFail(\Auth::user()->company_id);
        }

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
        if(!empty($bid->files)){
            foreach($bid->files as $file){
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

        return view('bid.manage_bid_files', compact('bid', 'invoice_files', 'dn_files', 'cn_files', 'logo_files', 'profile_files', 'support_files', 'registration_files', 'others_files', 'file_types', 'company'));
    }

    /**
     * Save bid files.
     */
    public function saveBidFile(Request $request, $id)
    {
        $bid = Bid::findOrFail($id);

        $this->authorize('ownership', $bid);

        if($request->file('file')){
            $destination_path = public_path().sprintf('/uploads/%s/bid_files/bid_id_%s/', $bid->company_id, $id);
            if($request->file('file')->isValid()){
                $file_name = $request->file('file')->getClientOriginalName();
                if($request->file('file')->move($destination_path, $file_name)){
                    $file_array = array(
                        'bid_id' => $id,
                        'file_type_id' => $request->input('file_type'),
                        'file_name' => $request->input('file_name'),
                        'link_path' => \URL::asset('uploads/'.$bid->company_id.'/bid_files/bid_id_'.$id.'/'.$file_name),
                        'status' => 'Active',
                        'created_by' => \Auth::id()
                    );

                    if(BidFile::create($file_array)){
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

        return redirect('/bid/manage_bid_files/'.$id);
    }

    /**
     * remove bid files.
     */
    public function deleteBidFile($file_id, $company_id)
    {
        $bid_file = BidFile::findOrFail($file_id);
        $status = false;

        $split_file_path = explode('/', $bid_file->link_path);
        $file_name = $split_file_path[count($split_file_path)-1];
        $old_file_path= public_path().'/uploads/'.$company_id.'/bid_files/bid_id_'.$bid_file->bid_id.'/'.$file_name;

        if(\File::delete($old_file_path) && $bid_file->delete()){
            $status = true;
        }

        return response()->json(['status' => $status]);
    }

    /**
     * Bid job.
     */
    public function bidJob($id)
    {
        $this->authorize('create', Bid::class);
        $job = Job::find($id);

        if(\Auth::user()->type == 'super_admin' || \Auth::user()->type == 'globe_admin'){
            $companies = Company::where('category', 'LSP')->where('delete', '0')->get();
        }

        return view('bid.bid_job', compact('job', 'companies'));
    }

    /**
     * Update bid status.
     */
    public function updateBidStatus(Request $request)
    {
        $bid = Bid::find($request->bid_id);

        $this->authorize('ownership', $bid);

        if($request->action){
            $bid->status_id = $request->action;
        }

        if($bid->save()){
            \Session::flash('success_message', 'Bid has been updated successfully.');
        }else{
            \Session::flash('alert_message', 'Bid cannot be updated.');
        }

        return redirect()->back();
    }

    /**
     * Check if company has enough unexpired credit to post a bid.
     */
    public function checkCreditStatus($id)
    {
        $status = false;
        if(\Auth::user()->type == 'super_admin' || \Auth::user()->type == 'globe_admin'){
            $status = true;
        }else{
            $company = Company::find($id);

            if($company){
                $expiry_timestamp = strtotime($company->credit_expiry);

                if($expiry_timestamp > time()){
                    if( ($company->credit_amount - $company->credit_unit_cost) >= 0){
                        $status = true;
                    }
                }
            }
        }

        return $status;
    }
}