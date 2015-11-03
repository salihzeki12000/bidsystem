<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobHighlight extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'job_highlight';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['job_id', 'highlight_id', 'status', 'created_by', 'modified_by', 'created_at', 'updated_at'];

}