<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplyMessage extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'reply_messages';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['reply_message_id', 'reply_to', 'status', 'created_by', 'modified_by'];

    public function reply_message()
    {
        return $this->belongsTo('App\Message', 'reply_message_id');
    }

    public function reply_to()
    {
        return $this->belongsTo('App\Message', 'reply_to');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
