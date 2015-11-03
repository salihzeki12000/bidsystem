<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyService extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'company_service';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['company_id', 'service_id', 'status', 'created_by', 'modified_by'];
}
