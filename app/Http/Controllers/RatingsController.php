<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Company;
use App\Rating;

class RatingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show list of companies.
     */
    public function listCompanies()
    {
        $companies = Company::where('category', 'LSP')->lists('company_name', 'id');

        return view('rating.list_companies', compact('companies'));
    }

    /**
     * Show the form for rating a company.
     */
    public function rateCompany(Request $request)
    {
        if(\Auth::user()->type == 'outward_group_admin' || \Auth::user()->type == 'outward_group_user'){
            \Session::flash('alert_message', "Rating only open for inward user.");
            return redirect()->back();
        }

//        if (!\Request::isMethod('post'))
//        {
//            \Session::flash('alert_message', "Invalid request.");
//            return redirect()->back();
//        }

        $company = Company::find($request->company_id);

        return view('rating.rate_company', compact('company'));
    }

    /**
     * Save rating.
     */
    public function saveRating(Request $request)
    {
        //var_dump($request->all());
        $rating_array = array(
            'company_id' => $request->company_id,
            'c' => $request->c,
            'e' => $request->e,
            't' => $request->t,
            'r' => $request->r,
            'a' => $request->a,
            'q' => $request->q,
            'comment' => $request->comment,
            'created_by' => \Auth::id()
        );

        $new_rating = Rating::create($rating_array);

        if($new_rating){
            return redirect('/rating/finish_rating');
        }else{
            \Session::flash('alert_message', "Rating cannot be submitted.");
            return redirect()->back()->withInput();
        }
    }

    /**
     * Rating finish page.
     */
    public function finishRating()
    {
        return view('rating.finish_rating');
    }

    /**
     * Rating finish page.
     */
    public function showAllRatings($id)
    {
        $company = Company::with('ratings.creator_company')->find($id);

        $rating_averages = Rating::select(\DB::raw('avg(c) c, avg(e) e, avg(t) t, avg(r) r, avg(a) a, avg(q) q'))
            ->where('company_id', $id)
            ->first();

        return view('rating.show_all_ratings', compact('company', 'rating_averages'));
    }

}
