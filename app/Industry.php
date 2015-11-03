<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'industries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['industry', 'status', 'created_by', 'modified_by'];

    public function company()
    {
        return $this->belongsToMany('App\Company');
    }
}
