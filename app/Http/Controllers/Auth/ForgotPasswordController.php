<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset_password()
    {
        $data['menu'] = "Reset Password";
        return view('admin.auth.passwords.email',$data);
    }

    public function send_password(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $user=User::where('email',$request['email'])->where('role','admin')->first();
        if(!empty($user)){
            $pass = str_random(8);
            $user['password']=$pass;
            $user->save();
            $email = $request['email'];
            $data['email'] = $request['email'];
            $data['name']=$user['name'];
            $data['pass'] = $pass;
            $bcc = [];

            \Mail::send('admin.auth.passwords.forgetemail',$data, function ($m) use ($email, $bcc) {
                $m->from('developers@thirdeyegen.com', 'thirdeye');
                $m->bcc($bcc);
                $m->to($email)->subject('Reset Password');
            });

            // return view('admin.auth.passwords.forgetemail',$data);

            \Session::flash('success','New Password Send To Your Mail Account Shortly.');
            return redirect()->back();
        }
        else{
            \Session::flash('forgeterror','email');
            return back()->withInput()->withErrors(['femail' => 'Invalid Email Please Try Again!']);
        }
    }
}
