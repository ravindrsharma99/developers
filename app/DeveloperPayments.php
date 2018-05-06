<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeveloperPayments extends Model
{
    protected $fillable = [
        'user_id', 'app_id', 'price', 'amount', 'owner_id', 'status', 'paypal_id', 'transaction_id', 'error', 'updated_at', 'created_at'
    ];

  
}
