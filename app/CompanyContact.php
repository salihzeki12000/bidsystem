<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyContact extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['created_by', 'modified_by', 'status', 'company_id',
        'contact_type_id', 'address_line_1', 'address_line_2', 'address_line_3',
        'postcode', 'town', 'state', 'country', 'tel_num', 'fax_num', 'website', 'pic_name',
        'pic_department', 'pic_designation', 'pic_mobile_num', 'pic_email_1', 'pic_email_2'
    ];

    /**
     * Get the users for the company.
     */
    public function company()
    {
        return $this->hasMany('App\Company');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

}
