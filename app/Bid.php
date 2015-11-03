<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'bids';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['job_id', 'company_id', 'date', 'est_budget', 'additional_description', 'reply_to_special_request', 'status_id',
        'sales_pic', 'rfp_submission_date', 'rfq_submission_date', 'first_meeting_target_date', 'closure_target_date', 'delete', 'created_by', 'modified_by'];

    public function job()
    {
        return $this->belongsTo('App\Job', 'job_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function rfi_status()
    {
        return $this->belongsTo('App\RfiState', 'status_id');
    }

    public function files()
    {
        return $this->hasMany('App\BidFile');
    }

}