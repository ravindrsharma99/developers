<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppDownload extends Model
{
    protected $fillable = [
        'user_id', 'app_id', 'price', 'developer_amount', 'admin_amount', 'commision_rate'
    ];

    public function user(){
        return $this->belongsTo('App\AppUser', 'user_id');
    }

    public function app(){
        return $this->belongsTo('App\NewApp', 'app_id');
    }
}
