<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyAchievement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_achievement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'category_id','descriptions', 'status', 'created_by', 'modified_by'];
}
