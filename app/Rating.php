<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'ratings';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['company_id', 'c', 'e', 't', 'r', 'a', 'q', 'comment', 'moderated', 'created_by', 'modified_by'];

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function creator_company()
    {
        return $this->belongsTo('App\User', 'created_by')
            ->join('companies', 'companies.id', '=', 'users.company_id');
    }
}
