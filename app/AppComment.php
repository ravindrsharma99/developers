<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class AppComment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'comment','rating','user_id', 'app_id'
    ];

    public function user(){
        return $this->belongsTo('App\AppUser', 'user_id');
    }

    public function app(){
        return $this->belongsTo('App\NewApp', 'app_id');
    }

    public function displayUpdatedAt($sFormat = "M d Y h:i a"){
        if(empty($this->updated_at)) {
            return '';
        }
    
        $createdAt = Carbon::parse($this->updated_at);
        return $createdAt->format($sFormat);
    }
}
