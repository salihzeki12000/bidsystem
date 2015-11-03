<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidFile extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'bid_files';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['bid_id', 'file_type_id', 'file_name', 'link_path', 'status', 'created_by', 'modified_by'];

    public function bid()
    {
        return $this->belongsTo('App\Bid', 'bid_id');
    }

    public function file_type()
    {
        return $this->belongsTo('App\FileType', 'file_type_id');
    }
}
