<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppUserToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token',
        'user_id',
        'device',
        'device_token'
    ];

    protected static $userToken = null;

    public static function getUserToken(){
        return self::$userToken;
    }

    public function user()
    {
        return $this->belongsTo('App\AppUser');
    }

    public static function check($token){
        $userToken = AppUserToken::with(['user'])->where('token', $token)->first();
        if(empty($userToken)) return false;
        if(!isset($userToken->user) || empty($userToken->user)) return false;

        return $userToken;
    }

    public static function createToken($user = null){
        if(!$user){
            $user = auth()->user();
        }
        
        if(empty($user)) return false;
        $token = str_random(32);
        $userToken = AppUserToken::create([
            'token' => $token,
            'user_id' => $user->id
        ]);

        self::$userToken = $userToken;

        return $token;
    }
}
