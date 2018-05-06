<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatterCategory extends Model
{
    protected $fillable = [
        'parent_id', 'order', 'name', 'color', 'slug'
    ];

    public function getTitle(){
        return $this->name;
    }
}
