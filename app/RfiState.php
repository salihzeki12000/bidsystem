<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RfiState extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rfi_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['rfi_status', 'description', 'created_by', 'modified_by'];


    public function jobs()
    {
        return $this->hasMany('App\Job');
    }

}
