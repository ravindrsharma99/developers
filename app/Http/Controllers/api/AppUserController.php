<?php

namespace App\Http\Controllers\api;

use App\AppUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AppUserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                    'email' => 'required',
                    'password' => 'required',
                ]
            );
            if ($validator->fails()) {
                $response["Result"] = 0;
                $response["Message"] = implode(',', $validator->errors()->all());
                return response($response, 400);
            }

            $appuser = AppUser::where("email", $request['email'])->first();
            if (empty($appuser)) {
                $response["Result"] = 0;
                $response["Message"] = "Email address or password is incorrect. Please try again.";
                return response($response, 403);
            }
            else {
                $dbpass = $appuser['password'];

                if ($request['password'] !== decrypt($dbpass)) {
                    $response["Result"] = 0;
                    $response["Message"] = "Email address or password is incorrect. Please try again.";
                    return response($response, 403);
                }
                else {
                    $appuser['session_token'] = str_random(30);
                    $appuser->save();
                    $user = AppUser::findorFail($appuser->id);
                    unset($user->password);
                    unset($user->deleted_at);

                    if ($user->profileimage != "" && file_exists($user['profileimage'])) {
                        $user->profileimage = url($user->profileimage);
                    }
                    $response["Result"] = 1;
                    $response["User"] = $user;
                    $response['Message'] = "User login Successfully.";
                    return response($response, 200);
                }
            }
        } catch (Exception $e) {
            return response("", 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'email' => 'required|email|unique:app_users,email',
                    'password' => 'required|min:6',
                    'profileimage' => 'required|mimes:jpeg,jpg,bmp,png',
                    'phone'=>'required',
                ]
            );
            if ($validator->fails()) {
                $response["Result"] = 0;
                $response["Message"] = implode(',', $validator->errors()->all());
                return response($response, 200);
            } else {

                $input = $request->all();

                if(empty($request['address']))
                {
                    $input['address'] = "";
                }
                else{
                    $input['address'] = $request['address'];
                }

                if($photo = $request->file('profileimage'))
                {
                    $root = base_path() . '/public/resource/Appuser/' ;
                    $name = str_random(20).".".$photo->getClientOriginalExtension();
                    if (!file_exists($root)) {
                        mkdir($root, 0777, true);
                    }

                    $image_path = "resource/Appuser/".$name;
                    $photo->move($root,$name);
                    $input['profileimage'] = $image_path;
                }

                $input['session_token'] = str_random(30);
                $appuser = AppUser::create($input);

                $user = AppUser::findorFail($appuser->id);

                if ($user->profileimage != "" && file_exists($user['profileimage'])) {
                    $user->profileimage = url($user->profileimage);
                }

                unset($user->deleted_at);
                unset($user->password);
                $response["Result"] = 1;
                $response["User"] = $user;
                $response['Message'] = "User Registered Successfully.";
                return response($response, 200);
            }

        } catch (Exception $e) {
            return response("", 500);
        }
    }

    public function profile_update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'session_token' => 'required',
                'password' => 'min:6',
            ]);

            if ($validator->fails()) {
                $response["Result"] = 0;
                $response["Message"] = implode(',', $validator->errors()->all());
                return response($response, 200);
            }

            $appuser = AppUser::where("session_token", $request['session_token'])->first();
            if (empty($appuser) || $request['session_token'] == "") {
                $response["Result"] = 0;
                $response["Message"] = "Your account may be logged in from other device or deactivated, please try to login again.";
                return response($response, 200);
            }

            if (!empty($appuser)) {
                $input = $request->all();
                if(empty($request['password'])){
                    unset($input['password']);
                }

                if($appuser['email'] != $request['email']){
                    $input['email'] = $appuser['email'];
                }

                if(empty($request['firstname']))
                {
                    $input['firstname'] = $appuser['firstname'];
            }
                else{
                    $input['firstname'] = $request['firstname'];
                }

                if(empty($request['lastname']))
                {
                    $input['lastname'] = $appuser['lastname'];
                }
                else{
                    $input['lastname'] = $request['lastname'];
                }

                if(empty($request['phone']))
                {
                    $input['phone'] = $appuser['phone'];
                }
                else{
                    $input['phone'] = $request['phone'];
                }

                if(empty($request['profileimage']))
                {
                    $input['profileimage'] = $appuser['profileimage'];
                }
                else{
                    if($photo = $request->file('profileimage'))
                    {
                        $root = base_path() . '/public/resource/Appuser/' ;
                        $name = str_random(20).".".$photo->getClientOriginalExtension();
                        $mimetype = $photo->getMimeType();
                        $explode = explode("/",$mimetype);
                        $type = $explode[0];
                        if (!file_exists($root)) {
                            mkdir($root, 0777, true);
                        }
                        $photo->move($root,$name);
                        $input['profileimage'] = "resource/Appuser/".$name;
                    }
                }

                if(empty($request['address']))
                {
                    $input['address'] = "";
                }
                else{
                    $input['address'] = $request['address'];
                }


                $appuser->update($input);

                unset($appuser->password);
                unset($appuser->deleted_at);
                $response["Result"] = 1;
                $response["User"] = $appuser;
                $response['Message'] = "User Profile Updated Successfully";
                return response($response, 200);
            }
        } catch (Exception $e) {
            return response("", 500);
        }
    }

    public function get_profile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'session_token' => 'required',
            ]);
            if ($validator->fails()) {
                $response["Result"] = 0;
                $response["Message"] = "Invalid session_token ";
                return response($response, 200);
            }
            $appuser = AppUser::where("session_token", $request['session_token'])->first();
            if (empty($appuser) || $request['session_token'] == "") {
                $response["Result"] = 0;
                $response["Message"] = "Your account may be logged in from other device or deactivated, please try to login again.";
                return response($response, 200);
            }

            if (!empty($appuser)) {

                if ($appuser->profileimage != "" && file_exists($appuser['profileimage'])) {
                    $appuser->profileimage = url($appuser->profileimage);
                }
                unset($appuser->password);
                unset($appuser->deleted_at);
                $response["Result"] = 1;
                $response["User"] = $appuser;
                $response['Message'] = "Success";
                return response($response, 200);

            }

        } catch (Exception $e) {
            return response("", 500);
        }

    }

    public function forgot_password(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                ]
            );
            if ($validator->fails()) {
                $response["Result"] = 0;
                $response["Message"] = implode(',', $validator->errors()->all());
                return response($response, 200);
            }
            $appuser = AppUser::where("email", $request['email'])->first();
            if (empty($appuser)) {
                $response["Result"] = 0;
                $response["Message"] = "Invalid email address.";
                return response($response, 200);
            } else {
                $pass=str_random(8);
                $appuser->password=$pass;
                $appuser->save();

                $to1=$request['email'];
                $from1='ilaxo.mit@gmail.com';
                $subject2='Forget Password';
                $mailcontent1="Dear <b>" .$appuser->name."</b>, You have requested to reset your password. Please use the password <b>" .$pass. "</b> to log in. After log in, please go to Profile page to change your password.";
                $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers .= "From: $from1\r\n";
                mail($to1,$subject2,$mailcontent1,$headers);
                $response["Result"]=1;
                $response["Message"] = "A new password has been sent to your registered email address.";
                return response($response, 200);
            }

        } catch (Exception $e) {
            return response("", 500);
        }
    }
}
