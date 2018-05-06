<?php

namespace App\Services\Auth;

use App\AppUser as User;
use App\AppUserToken as UserToken;

class Dmobi
{
    protected $user;
    protected $userToken;
    public function __construct($params)
    {

    }

    public function check()
    {
        if (!empty($this->user)) {
            return true;
        }

        $this->getUser();
        if (empty($this->user)) {
            return false;
        }

        return true;
    }

    public function getUser()
    {
        $request = request();
        $authenticationtoken = $request->header('authentication-token');
        if (empty($authenticationtoken)) {
            return false;
        }

        $userToken = UserToken::check($authenticationtoken);
        if(empty($userToken)) return false;
        $user = $userToken->user;
        if (empty($user)) {
            return false;
        }
        $this->userToken = $userToken;
        $this->user = $user;
        $request->merge(['user' => $this->user]);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });
    }

    public function user()
    {
        return $this->user;
    }

    public function logout(){
        if(empty($this->user)) return false;
        $this->userToken->delete();
        return true;
    }

    public function token(){
        return $this->userToken;
    }

    public function attempt($fields = []){
        if(empty($fields)) return false;
        if(!isset($fields['password']) || empty($fields['password'])) return false;

        $query = null;
        foreach($fields as $k => $v){
            if($k != 'password'){
                if(!$query){
                    $query = User::where($k, $v);
                }
                else{
                    $query->where($k, $v);
                }
            }
        }
        if(!$query) return false;
        $user = $query->first();
        if(!$user) return false;
        try {
            $password = decrypt($user->password);
            if($fields['password'] != $password) return false;
        } catch (DecryptException $e) {
            return false;
        }
        
        $this->user = $user;
        return true;
    }
}
