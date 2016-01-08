<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'requirements';

    protected $fillable = ['requirement', 'status', 'created_by', 'modified_by'];

    public function jobs()
    {
        return $this->belongsToMany('App\Job', 'job_requirement')->withPivot('id');
    }
}
