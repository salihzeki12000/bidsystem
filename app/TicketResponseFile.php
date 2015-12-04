<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketResponseFile extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'ticket_response_files';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['ticket_response_id', 'file_name', 'file_path', 'created_by', 'modified_by'];

    public function ticket_response()
    {
        return $this->belongsTo('App\TicketResponse', 'ticket_response_id');
    }
}