<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logistic extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'logistics';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'status', 'created_by', 'modified_by'];
}
