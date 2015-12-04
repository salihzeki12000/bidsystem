<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketAdminEmail extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'ticket_admin_email';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['email', 'created_by', 'modified_by'];
}
