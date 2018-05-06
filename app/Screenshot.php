<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screenshot extends Model
{
    protected $fillable = [
        'app_id','image'
    ];

    public function NewApp()
    {
        return $this->belongsTo('App\NewApp', 'app_id');
    }

}
