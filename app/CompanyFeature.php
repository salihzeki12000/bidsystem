<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyFeature extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_features';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'feature','details', 'status', 'created_by', 'modified_by'];

    /**
     * Get the owner of the feature.
     */
    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }
}
