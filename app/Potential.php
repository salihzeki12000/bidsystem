<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Potential extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'potentials';

    protected $fillable = ['potential', 'status', 'created_by', 'modified_by'];
}
