<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentResponse extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'appointment_response';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['appointment_request_id', 'description', 'response_action', 'created_by', 'modified_by'];

    public function request()
    {
        return $this->belongsTo('App\AppointmentRequest', 'appointment_request_id');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}