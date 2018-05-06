<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'app_id',
        'order_code',
        'payment_type', 
        'amount', 
        'user_id', // app user
        'owner_id', // developer
        'status', 
        'transaction_id',
        // storage error
        'error',
        'data',
        'commision_rate',
        'developer_amount',
        'admin_amount'
    ];

    const PENDING = 'pending';
    const FAILED = 'failed';
    const SUCCESS = 'success';
    const PAYMENT_TYPES = [
        'BUY_APP' => 'buy_app'
    ];

    public function NewApp()
    {
        return $this->belongsTo('App\NewApp', 'app_id');
    }

    public function app()
    {
        return $this->belongsTo('App\NewApp', 'app_id');
    }

    public function user(){
        return $this->belongsTo('App\AppUser', 'user_id');
    }

    public function owner(){
        return $this->belongsTo('App\WebUser', 'owner_id');
    }
}
