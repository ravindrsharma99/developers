<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BtCustomer extends Model
{
    protected $fillable = [
        'user_id', 
        'customer_id'
    ];

}