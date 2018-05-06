<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppViewer extends Model
{
    protected $fillable = [
        'user_id', 'app_id'
    ];

    public function user(){
        return $this->belongsTo('App\AppUser', 'user_id');
    }

    public function app(){
        return $this->belongsTo('App\NewApp', 'app_id');
    }
}
