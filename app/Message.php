<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['sender', 'receiver', 'subject', 'message_type', 'is_read', 'description', 'status', 'created_by', 'modified_by'];

    public function get_sender()
    {
        return $this->belongsTo('App\Company', 'sender');
    }

    public function get_receiver()
    {
        return $this->belongsTo('App\Company', 'receiver');
    }

    public function reply_messages()
    {
        return $this->hasMany('App\ReplyMessage', 'reply_to');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}