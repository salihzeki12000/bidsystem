<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyCreditTransaction extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'company_credit_transactions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['company_id','amount', 'type', 'comment', 'created_by', 'modified_by'];
}
