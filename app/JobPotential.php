<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPotential extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_potential';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['job_id', 'potential_id', 'status', 'created_by', 'modified_by'];
}