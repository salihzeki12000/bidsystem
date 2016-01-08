<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Job extends Model
{
    use SearchableTrait;

    /**
     * The database table used by the model.
     */
    protected $table = 'jobs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['company_id', 'date', 'location_id', 'additional_description', 'special_request', 'existing_budget',
        'existing_lsp', 'contract_term', 'close_date', 'announcement_date', 'outsource_start_date', 'award_to', 'status_id',
        'keyword', 'created_by', 'modified_by'];

    /**
     * Searchable rules.
     */
    protected $searchable = [
        'columns' => [
            'jobs.additional_description' => 10,
            'jobs.special_request' => 10,
            'jobs.keyword' => 5,
        ],
    ];

    public function files()
    {
        return $this->hasMany('App\JobFile');
    }

    public function bids()
    {
        return $this->hasMany('App\Bid');
    }

    public function validBids($ids)
    {
        return $this->hasMany('App\Bid')->whereIn('status_id', $ids);
    }

    public function valid_bids()
    {
        return $this->hasMany('App\Bid')->whereIn('status_id', [6, 7, 8, 9, 10]);
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function rfi_status()
    {
        return $this->belongsTo('App\RfiState', 'status_id');
    }

    public function location()
    {
        return $this->belongsTo('App\CountryStateTown', 'location_id');
    }

    public function requirements()
    {
        return $this->belongsToMany('App\Requirement', 'job_requirement')->withPivot('id');
    }

    public function potentials()
    {
        return $this->belongsToMany('App\Potential', 'job_potential')->withPivot('id');
    }

    public function highlights()
    {
        return $this->belongsToMany('App\Highlight', 'job_highlight')->withPivot('id');
    }
}