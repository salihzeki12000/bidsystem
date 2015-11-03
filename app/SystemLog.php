<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'system_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['action_type', 'action_description', 'perform_by', 'ip_address_of_initiator', 'target_id', 'target_category', 'result', 'created_by', 'modified_by'];

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'perform_by');
    }
}
