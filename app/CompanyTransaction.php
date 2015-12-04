<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyTransaction extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'company_transactions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['company_id','amount', 'type', 'item_id', 'description', 'created_by', 'modified_by'];
}