<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyFile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['file_name', 'company_id','file_type', 'file_path', 'status', 'created_by', 'modified_by'];

    /**
     * Get the owner of the file.
     */
    public function createdBy()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }
}
