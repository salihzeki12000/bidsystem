<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'tickets';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['company_id', 'category_id', 'issue_subject', 'issue_description', 'status', 'created_by', 'modified_by'];

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function category()
    {
        return $this->belongsTo('App\TicketCategory', 'category_id');
    }

    public function files()
    {
        return $this->hasMany('App\TicketFile');
    }

    public function responses()
    {
        return $this->hasMany('App\TicketResponse');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}