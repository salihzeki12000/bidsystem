<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyPotential extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_potential';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'potential_id', 'status', 'created_by', 'modified_by'];
}
