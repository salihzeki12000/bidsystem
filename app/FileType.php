<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'file_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['file_type', 'status', 'created_by', 'modified_by'];

}
