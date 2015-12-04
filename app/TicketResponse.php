<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketResponse extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'ticket_responses';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['ticket_id', 'reply_description', 'created_by', 'modified_by'];

    public function ticket()
    {
        return $this->belongsTo('App\Ticket', 'ticket_id');
    }

    public function files()
    {
        return $this->hasMany('App\TicketResponseFile');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
