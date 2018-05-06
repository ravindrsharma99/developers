<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatterPost extends Model
{
    protected $table = 'chatter_post';

    protected $fillable = [
        'chatter_discussion_id', 'user_id', 'body', 'markdown', 'locked'
    ];

    public function user(){
        return $this->belongsTo('App\WebUser', 'user_id');
    }
}
