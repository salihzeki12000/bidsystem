<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentObjectives extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'appointment_objectives';

    protected $fillable = ['app_objective', 'description','status', 'created_by', 'modified_by'];
}
