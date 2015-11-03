<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'services';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'status', 'created_by', 'modified_by'];
}
