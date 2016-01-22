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
        $companies = Company::where('category', 'LSP')->where('delete', '0')->lists('company_name', 'id');

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

        if($request->company_id != \Auth::user()->company_id){
            $company = Company::find($request->company_id);
            $rating = Rating::where('rate_by', \Auth::user()->company_id)->where('company_id', $request->company_id)->first();
        }else{
            \Session::flash('alert_message', "You cannot rate yourself.");
            return redirect()->back();
        }

        //dd($rating->toArray());

        return view('rating.rate_company', compact('company', 'rating'));
    }

    /**
     * Save rating.
     */
    public function saveRating(Request $request)
    {
        //var_dump($request->all());

        if(!empty($request->rating_id)){
            $rating = Rating::findOrFail($request->rating_id);
            $rating->c = $request->c;
            $rating->e = $request->e;
            $rating->t = $request->t;
            $rating->r = $request->r;
            $rating->a = $request->a;
            $rating->q = $request->q;
            $rating->comment = $request->comment;
            $rating->modified_by = \Auth::id();

            if($rating->save()){
                return redirect('/rating/finish_rating');
            }else{
                \Session::flash('alert_message', "Rating cannot be submitted.");
                return redirect()->back()->withInput();
            }
        }else{
            $rating_array = array(
                'company_id' => $request->company_id,
                'c' => $request->c,
                'e' => $request->e,
                't' => $request->t,
                'r' => $request->r,
                'a' => $request->a,
                'q' => $request->q,
                'comment' => $request->comment,
                'rate_by' => \Auth::user()->company_id,
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

        //dd($company->toArray());

        $rating_averages = Rating::select(\DB::raw('avg(c) c, avg(e) e, avg(t) t, avg(r) r, avg(a) a, avg(q) q'))
            ->where('company_id', $id)
            ->first();

        return view('rating.show_all_ratings', compact('company', 'rating_averages'));
    }

}
