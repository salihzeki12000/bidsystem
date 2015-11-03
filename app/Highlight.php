<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'highlights';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['highlight', 'status', 'created_by', 'modified_by'];
}
