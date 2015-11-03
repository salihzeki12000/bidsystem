<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobFile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['job_id', 'file_type_id', 'file_name', 'link_path', 'status', 'created_by', 'modified_by'];


    public function job()
    {
        return $this->belongsTo('App\Job', 'job_id');
    }

    public function file_type()
    {
        return $this->belongsTo('App\FileType', 'file_type_id');
    }
}