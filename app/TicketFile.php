<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketFile extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'ticket_files';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['ticket_id', 'file_name', 'file_path', 'created_by', 'modified_by'];

    public function ticket()
    {
        return $this->belongsTo('App\Ticket', 'ticket_id');
    }
}
