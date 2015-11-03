<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobRequirement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_requirement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['job_id', 'requirement_id', 'status', 'created_by', 'modified_by'];
}
