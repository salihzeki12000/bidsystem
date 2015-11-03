<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyRequirement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_requirement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'requirement_id', 'status', 'created_by', 'modified_by'];
}
