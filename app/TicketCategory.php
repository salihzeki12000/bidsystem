<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'ticket_categories';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'status', 'created_by', 'modified_by'];
}
