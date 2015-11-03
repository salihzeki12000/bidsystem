<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyRemark extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_remarks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'remarks', 'status', 'created_by', 'modified_by'];

    /**
     * Get the owner of the industry.
     */
    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }
}
