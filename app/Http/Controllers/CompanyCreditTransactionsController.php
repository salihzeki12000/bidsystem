<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Company;
use App\CompanyCreditTransaction;
use Gate;

class CompanyCreditTransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function newCreditTransaction($id)
    {
        if (Gate::denies('globe-admin-above')) {
            \Session::flash('alert_message', 'Unauthorized action.');
            return redirect('/home');
        }

        $company = Company::findOrFail($id);
        if(!empty($company->credit_expiry)){
            $new_expiry_date = strtotime($company->credit_expiry);
            $company->credit_expiry = date('d-m-Y H:i', $new_expiry_date);
        }

        return view('credit.new_credit_transaction', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('globe-admin-above')) {
            \Session::flash('alert_message', 'Unauthorized action.');
            return redirect('/home');
        }

        $credit_transaction_array = array(
            'company_id' => $request->company_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'comment' => $request->comment,
            'created_by' => \Auth::user()->id
        );

        $new_credit_transaction = CompanyCreditTransaction::create($credit_transaction_array);

        if($new_credit_transaction){
            $company = Company::find($request->company_id);
            if($request->type == 'top-up'){
                $company->credit_amount = $company->credit_amount + $request->amount;
            }else if($request->type == 'deduction'){
                $company->credit_amount = $company->credit_amount - $request->amount;
            }else if($request->type == 'edit'){
                $company->credit_amount = $request->amount;
            }else{
                $company->credit_unit_cost = $request->amount;
            }
            if($company->save()){
                \Session::flash('success_message', 'Credit transaction has been saved.');
            }else{
                \Session::flash('alert_message', 'Credit cannot be changed for this company.');
            }
        }else{
            \Session::flash('alert_message', 'Credit transaction cannot be saved.');
        }

        return redirect()->back();
    }

    /**
     * Change credit expiry date for specified company.
     */
    public function changeExpiryDate(Request $request)
    {
        if (Gate::denies('globe-admin-above')) {
            \Session::flash('alert_message', 'Unauthorized action.');
            return redirect('/home');
        }

        $refined_expiry_date = date('Y-m-d H:i', strtotime($request->expiry_date));
        $company = Company::find($request->company_id);
        $company->credit_expiry = $refined_expiry_date;

        if($company->save()){
            \Session::flash('success_message', 'Credit expiry date has been changed.');
        }else{
            \Session::flash('alert_message', 'Credit expiry date cannot be changed.');
        }

        return redirect()->back();
    }
}