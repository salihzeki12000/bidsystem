<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentRequest extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'appointment_request';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['sender', 'receiver', 'no_of_pic', 'objective_id', 'description', 'location', 'date_time', 'status', 'created_by', 'modified_by'];

    public function objective()
    {
        return $this->belongsTo('App\AppointmentObjectives', 'objective_id');
    }

    public function response()
    {
        return $this->hasMany('App\AppointmentResponse');
    }

    public function get_sender()
    {
        return $this->belongsTo('App\Company', 'sender');
    }

    public function get_receiver()
    {
        return $this->belongsTo('App\Company', 'receiver');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
