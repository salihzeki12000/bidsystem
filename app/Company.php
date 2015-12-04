<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['company_name','category', 'date_joined',
        'date_operation_started', 'registration_num', 'paid_up_capital',
        'logo', 'no_of_employees', 'annual_turnover', 'keyword', 'physical_file_number',
        'billing_period', 'include_gst', 'gst_percent', 'status', 'account_quota', 'credit_amount', 'credit_unit_cost', 'credit_expiry',
        'delete', 'created_by', 'modified_by'
    ];

    /**
     * Get the users for the company.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function contacts()
    {
        return $this->hasMany('App\CompanyContact');
    }

    public function files()
    {
        return $this->hasMany('App\CompanyFile');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function industries()
    {
        return $this->belongsToMany('App\Industry', 'company_industry')->withPivot('id');
    }

    public function requirements()
    {
        return $this->belongsToMany('App\Requirement', 'company_requirement')->withPivot('id');
    }

    public function potentials()
    {
        return $this->belongsToMany('App\Potential', 'company_potential')->withPivot('id');
    }

    public function features()
    {
        return $this->hasMany('App\CompanyFeature');
    }

    public function remarks()
    {
        return $this->hasMany('App\CompanyRemark');
    }

    public function achievements()
    {
        return $this->belongsToMany('App\Achievement', 'company_achievement', 'company_id', 'category_id')->withPivot('id', 'descriptions');
    }

    public function jobs()
    {
        return $this->hasMany('App\Job');
    }

    public function valid_jobs()
    {
        return $this->hasMany('App\Job')->whereNotIn('status_id', [1, 5]);
    }

    public function bids()
    {
        return $this->hasMany('App\Bid');
    }

    public function valid_bids()
    {
        return $this->hasMany('App\Bid')->whereNotIn('status_id', [1, 5]);
    }

    public function logistics()
    {
        return $this->belongsToMany('App\Logistic', 'company_logistic')->withPivot('id');
    }

    public function services()
    {
        return $this->belongsToMany('App\Service', 'company_service')->withPivot('id');
    }

    public function ratings()
    {
        return $this->hasMany('App\Rating')->orderBy('updated_at', 'desc');
    }
}