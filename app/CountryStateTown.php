<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryStateTown extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'country_state_towns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['town', 'state', 'country', 'postcode', 'status', 'created_by', 'modified_by'];
}
