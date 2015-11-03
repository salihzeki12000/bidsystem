<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyIndustry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_industry';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'industry_id','status', 'created_by', 'modified_by'];
}
