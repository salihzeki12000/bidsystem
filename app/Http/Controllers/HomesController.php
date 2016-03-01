<?php

namespace App\Http\Controllers;

use App\CompanyIndustry;
use App\CountryStateTown;
use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\Company;
use Carbon\Carbon;
use App\Bid;
use App\AppointmentRequest;
use App\Message;
use App\Industry;

class HomesController extends Controller
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
        if(\Auth::user()->type == 'inward_group_user' || \Auth::user()->type == 'inward_group_admin'){
            //info for outsourcers
            $total_number_of_suppliers = Company::where('status', 'Active')->where('delete', 0)->where('category', 'LSP')->get();
            $new_suppliers = array();
            if(count($total_number_of_suppliers) > 0){
                foreach($total_number_of_suppliers as $supplier){
                    if(Carbon::now()->diffInDays($supplier->created_at) < 30 && $supplier->created_at > Carbon::now()){
                        $new_suppliers[] = $supplier->toArray();
                    }
                }
            }
            $expiring_jobs = Job::where('delete', 0)->where('status_id', 4)->where('company_id', \Auth::user()->company_id)->where('close_date', '>=', Carbon::now()->subDays(30))->where('close_date', '<=', Carbon::now()->addDays(30))->get();

            $new_appointments_request = AppointmentRequest::where('receiver', \Auth::user()->company_id)->where('status', 'Unconfirmed')->get();
            $new_messages = Message::where('receiver', \Auth::user()->company_id)->where('is_read', 0)->get();

            $own_jobs = Job::where('delete', 0)->where('status_id', 4)->where('company_id', \Auth::user()->company_id)->lists('id');
            $incoming_bids = Bid::where('status_id', 7)->whereIn('job_id', $own_jobs->toArray())->lists('id');
        }else if(\Auth::user()->type == 'outward_group_user' || \Auth::user()->type == 'outward_group_admin'){
            //info for LSP
            $total_number_of_outsourcers = Company::with('industries')->where('status', 'Active')->where('delete', 0)->where('category', 'Outsourcing')->get();

            $companies_group_by_industry = array();
            if(count($total_number_of_outsourcers) > 0){
                foreach($total_number_of_outsourcers as $company){
                    if(Carbon::now()->diffInDays($company->created_at) < 30){
                        if(count($company->industries) > 0){
                            foreach($company->industries as $industry){
                                unset($company->industries);
                                $companies_group_by_industry[$industry->industry][] = $company->toArray();
                            }
                        }
                    }
                }
            }

            $unbid_jobs = Job::with('company')->where('close_date', '>=', Carbon::now()->subDays(30))->where('close_date', '<=', Carbon::now()->addDays(30))->get();

            foreach($unbid_jobs as $job_key => $job){
                $bids = $job->validBids([6, 7, 8, 9, 10])->get();
                if(count($bids) > 0){
                    unset($unbid_jobs[$job_key]);
                }
            }

            $new_appointments_request = AppointmentRequest::where('receiver', \Auth::user()->company_id)->where('status', 'Unconfirmed')->get();
            $new_messages = Message::where('receiver', \Auth::user()->company_id)->where('is_read', 0)->get();
        }else{
            //info for admin
            $industries = Industry::join('company_industry', 'industries.id', '=', 'company_industry.industry_id')
                ->join('companies', 'company_industry.company_id', '=', 'companies.id')
                ->join('jobs', 'companies.id', '=', 'jobs.company_id')
                ->select(\DB::raw('count(jobs.id) as count, industries.industry'))
                ->where('jobs.created_at', '>=', Carbon::now()->startOfMonth())
                ->where('jobs.created_at', '<=', Carbon::now()->endOfMonth())
                ->where('jobs.status_id', '=', 4)
                ->groupBy('industries.industry')
                ->get();

            $sum_new_jobs = 0;
            if(count($industries) > 0){
                foreach ($industries as $item) {
                    $sum_new_jobs += $item['count'];
                }
            }

            $locations = CountryStateTown::join('jobs', 'jobs.location_id', '=', 'country_state_towns.id')
                ->join('bids', 'bids.job_id', '=', 'jobs.id')
                ->select(\DB::raw('count(bids.id) as count, country_state_towns.country, country_state_towns.state, country_state_towns.town'))
                ->where('bids.created_at', '>=', Carbon::now()->startOfMonth())
                ->where('bids.created_at', '<=', Carbon::now()->endOfMonth())
                ->groupBy('country_state_towns.id')
                ->get();

            $sum_new_bids = 0;
            if(count($locations) > 0){
                foreach ($locations as $item) {
                    $sum_new_bids += $item['count'];
                }
            }

            $new_lsp = Company::where('delete', '0')->where('category', 'LSP')->where('created_at', '>=', Carbon::now()->startOfMonth())->where('created_at', '<=', Carbon::now()->endOfMonth())->get();
            $new_outsourcer = Company::join('company_industry', 'companies.id', '=', 'company_industry.company_id')
                ->join('industries', 'industries.id', '=', 'company_industry.industry_id')
                ->select(\DB::raw('count(companies.id) as count, industries.industry'))
                ->where('companies.delete', '0')
                ->where('companies.category', 'LSP')
                ->where('companies.created_at', '>=', Carbon::now()->startOfMonth())
                ->where('companies.created_at', '<=', Carbon::now()->endOfMonth())
                ->groupBy('industries.industry')
                ->get();
            $total_new_outsourcer = 0;

            if(count($new_outsourcer) > 0){
                foreach($new_outsourcer as $key => $counter){
                    $total_new_outsourcer+=$counter['count'];
                }
            }

            $current_month = Carbon::now()->month;

            $new_tickets = Ticket::with('company')->where('is_attended', 0)->get();

            switch ($current_month){
                case 1:
                    $current_month = 'January';
                    break;
                case 2:
                    $current_month = 'February';
                    break;
                case 3:
                    $current_month = 'March';
                    break;
                case 4:
                    $current_month = 'April';
                    break;
                case 5:
                    $current_month = 'May';
                    break;
                case 6:
                    $current_month = 'June';
                    break;
                case 7:
                    $current_month = 'July';
                    break;
                case 8:
                    $current_month = 'August';
                    break;
                case 9:
                    $current_month = 'September';
                    break;
                case 10:
                    $current_month = 'October';
                    break;
                case 11:
                    $current_month = 'November';
                    break;
                case 12:
                    $current_month = 'December';
                    break;
                default:
                    break;
            }
        }
        return view('home.index', compact('new_lsp', 'new_outsourcer', 'current_month', 'new_appointments_request', 'new_messages', 'incoming_bids', 'new_tickets', 'expiring_jobs', 'total_number_of_suppliers', 'new_suppliers', 'total_number_of_outsourcers', 'companies_group_by_industry', 'unbid_jobs', 'industries', 'locations', 'sum_new_jobs', 'sum_new_bids', 'total_new_outsourcer'));
    }

    /**
     * show company list.
     */
    public function companyList()
    {
        return view('home.company_list');
    }
}