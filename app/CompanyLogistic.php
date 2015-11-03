<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyLogistic extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'company_logistic';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['company_id', 'logistic_id', 'status', 'created_by', 'modified_by'];
}
