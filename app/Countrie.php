<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countrie extends Model
{
    protected $table="countries";
    protected $fillable = [
        'sortname','name','phonecode',
    ];
}
