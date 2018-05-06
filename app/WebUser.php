<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebUser extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name','email', 'password','city','state','companyname','status','is_active','country','terms_agree',
        'balance', 'withdrawal_pending', 'paypal_email', 'total_earned', 'total_withdrawal'
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = encrypt($password);
    }

    public function getApps($params = []){
        // get related app from same categories

        $length = isset($params['length']) ? (int) $params['length'] : 20;
        $start = isset($params['start']) ? (int) $params['start'] : 0;

        $apps = \App\NewApp::where('userid', $this->id)
        ->where('status', 'active')
        ->skip($start)
        ->take($length)
        ->orderBy('id', 'DESC')
        ->get();

        return $apps;
    
    }

    public function getTitle(){
        return $this->name;
    }

    public function getAdminHref(){
        return route('webusers.show', ['webusers' => $this]);
    }
}
