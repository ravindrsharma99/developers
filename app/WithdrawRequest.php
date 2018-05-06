<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mail;
use App\Mail\WithdrawEmail;

class WithdrawRequest extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'status', 'failure_reason', 'process_date', 'paypal_email', 'code'
    ];

    const PENDING = 'pending';
    const SUCCESS = 'success';
    const FAILED = 'failed';
    const PROCESSING = 'processing';

    public function user(){
        return $this->belongsTo('App\WebUser', 'user_id');
    }

    public function sendEmail(){
        if($this->status == WithdrawRequest::PENDING) return;
        Mail::to($this->user->email)->send(new WithdrawEmail($this));
    }
}
