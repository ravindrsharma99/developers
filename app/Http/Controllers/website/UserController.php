<?php

namespace App\Http\Controllers\website;
use App\AppUser;
use App\Category;
use App\Citie;
use App\Countrie;
use App\State;
use App\WebUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    public function reset_password(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $user=WebUser::where('email',$request['email'])->first();

        if(!empty($user)){
            $pass = str_random(8);
            $user['password']=$pass;
            $user->save();
            $to1 = $request['email'];
            $from1 = 'developers@thirdeyegen.com';
            $subject2 = 'Forget Password';
            $mailcontent1 = "Dear <b>" . $user->name . "</b>, You have requested to reset your password. Please use the password <b>" . $pass . "</b> to log in. After log in, please go to Profile page to change your password.";
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "From: $from1\r\n";
            mail($to1, $subject2, $mailcontent1, $headers);
            \Session::flash('success','New Password Send To Your Mail Account Shortly.');
            return redirect('/forgetpassword');
        }
        else{
            \Session::flash('forgeterror','Invalid Email Please Try Again!');
            return back()->withInput()->withErrors(['femail' => 'Invalid Email Please Try Again!']);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }

    public function login_view(Request $request)
    {
        if (session()->get('SESS_USER')){
            return redirect('/dashboard');
        }
        $data['country'] = Countrie::pluck('name','id')->all();
        $data['state'] = State::pluck('name','id')->all();
        $data['city'] = Citie::pluck('name','id')->all();
        return view('website.user.login',$data);
    }

    public function sub_category($id)
    {
        $options = '<option value="">Please Select</option>';
        $co = Countrie::where('id',$id)->first();
        $types = State::where('country_id',$co->id)->get();
        foreach ($types as $type){
            $options .= '<option value="'.$type['id'].'">'.$type['name'].'</option>';
        }
       // return $options;
        echo $options;
        return '';
    }

    public function sub_sub_category($state,$country)
    {

        //return $state;
        //return $state;
        $options = '<option value="">Please Select</option>';

       // $area = Countrie::where('id',$country)->first();
        $region1 = State::where('country_id',$country)->first();
        $types = Citie::where('state_id',$state)->orderBy('name','ASC')->get();
        foreach ($types as $type){
            $options .= '<option value="'.$type['id'].'">'.$type['name'].'</option>';
        }
       // return $options;
        echo $options;
        return '';
    }

    public function forget_password_view(Request $request)
    {
        return view('website.user.forget_password');
    }

    public function loggedin(Request $request){
        $this->validate($request, [
            'email_login' => 'required|email',
            'password_login' => 'required',
        ]);

        $user  = WebUser::where('email',$request['email_login'])->first();
        // echo "<pre>";
        // print_r($user);die;
        if (!empty($user)){
              $upass = Crypt::decrypt($user['password']);
              // print_r($upass);die;
             if ($request['password_login'] == $upass) {
              session(['SESS_USER' => $user]);
                session()->get('SESS_USER');
                return redirect('/dashboard');
            }
            else{
                \Session::flash('loginerror','password');
                return back()->withInput()->withErrors(['password_login' => 'Incorrect password, please try again!']);
            }
        }
        else{
            \Session::flash('loginerror','email');
            return back()->withInput()->withErrors(['email_login' => 'Incorrect Email, please try again!']);
        }
    }

    public function registration(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:web_users,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'country'=>'required',
            'state'=>'required',
            'city'=>'required',
            'companyname'=>'required',
        ]);
        $webuser=WebUser::where('email',$request['email'])->count();
             if($webuser > 0){
                 \Session::flush();
                 \Session::flash('registererror','email');
                 return back()->withInput()->withErrors(['email' => 'Email already taken, please try again!']);
             }



        $input = $request->all();
     //   return $request['terms_agree'];
        if($request['terms_agree']=="on"){
            $input['terms_agree'] = 1;
        }
        else{
            $input['terms_agree'] = 0;
        }
        
     //  $request['session_token'] = str_random(30);
     //  $request['is_active'] = 1;

       $user=WebUser::create($input);

        //session(['SESS_USER' => $user]);

//        $url=URL::to('home');
//        $to1 = $request['email'];
//        $from1 = 'admin@appigizer.com';
//        $subject2 = 'Registration Confirmation';
//        $name=$request['name'];
//
//         $mailcontent1='
//            <html>
//            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
//
//            <head>
//                <meta charset="UTF-8">
//                <title>Appigizer</title>
//                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
//            </head>
//            <body style="color: #000000; font-size: 16px; font-weight: 400; font-family: PingFangHK, sans-serif; margin: 0;">
//
//                    <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
//            <tr>
//                <td height="20"></td>
//            </tr>
//            <tr>
//                <td align="center" valign="top">
//                <table cellpadding="0" cellspacing="0" width="700px" style="border:thin;border-color:#1aadaa; border-style:solid;">
//                        <tr>
//                            <td>
//                                <div style="padding:10px 10px 10px 20px; background-color:#7fbf00; color:#ffffff; font-size:16px; font-family: PingFangHK-SemiBold, sans-serif;"> Registration Confirmation </div>
//                                <div style="padding:10px 10px 10px 20px;">
//                                   <p>Hey '.$name.', <br>
//                                   Welcome to Appigizer!</p>
//                                   <p>Starting today, you can learn anything. Here us what to expect as you get started with Appigizer. Get Started with Top Categories.
//                                   </p>
//
//                                </div>
//
//                                <div>
//                                    <hr style="border: 0; width: 100%; color: #183D6B; background-color: #7fbf00;	height: 4px;">
//                                  <pre style="color: #4D4D4D"><a href="'.$url.'">Click here</a></pre> to goto homepage
//
//                                </div>
//
//                            </td>
//                        </tr>
//                    </table>
//                    </td>
//            </tr>
//        </table>
//
//        </body>
//        </html>';
//
//        // $mailcontent1 = "Dear <b>" . $request['name'] . "</b>, Your registration successful. After log in, please go to Profile page to change your profile.";
//        $headers= "MIME-version: 1.0\n";
//        $headers.= "Content-type: text/html; charset= iso-8859-1\n";
//
//        $headers .= "From: $from1\r\n";
//        mail($to1, $subject2, $mailcontent1, $headers);
//        $email = $request['email'];
//        $data['name']=$request['name'];
//       // $data['token'] = $user['session_token'];
//        $data['link'] = "www.google.com";
//        $data['url']=URL::to('home');
//
//        $bcc = [];
//        //return view('website.user.reg_template',$data);
//            \Mail::send('website.user.reg_template',$data, function ($m) use ($email, $bcc) {
//                $m->from('admin@appigizer.com', 'Appigizer');
//                $m->bcc($bcc);
//                $m->to($email)->subject('Registration Confirmation');
//            });
       // return view('website.user.reg_template',$data);
        \Session::flash('success','Registration successfully, please check email to activate your account.');
        return redirect('/login');
    }

    public function account()
    {
        $data['menu']='WebUserAcount';
        $data['user']= session()->get('SESS_USER');

        $data['country'] = Countrie::pluck('name','id')->all();
        $data['state'] = State::where('country_id',$data['user']['country'])->pluck('name','id')->all();
        $data['city'] = Citie::where('state_id',$data['user']['state'])->pluck('name','id')->all();
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();
        return view('website.user.profile',$data);
    }

    public function update_account(Request $request){
        session()->forget('SESS_APP');
        $data['user']= session()->get('SESS_USER');
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:web_users,email,'.$data['user']['id'].',id',
            'password' => 'confirmed',
            'city'=>'required',
            'state'=>'required',
            'companyname'=>'required',
            'paypal_email' => 'required|email'
        ]);
        $user = WebUser::findorFail($data['user']['id']);
      //  return $user;
        $input = $request->all();

        if(!empty($request['password'])){
            $input['password']=$request['password'];
        }
        else{
            unset($input['password']);
        }
        $user->update($input);
        session(['SESS_USER' => $user]);
        \Session::flash('success','Account has been updated successfully!');
        return redirect('/account');
    }

    public function account_active($id){
        $data['menu'] = 'Active';
        $user = WebUser::where('session_token',$id)->first();

        if(empty($user))
        {
            $data['active_status'] = "2";
        }
        else{
            if ($user['is_active']==0){
                $data['active_status'] = "0";
            }
            else{
                $data['active_status'] = "1";
            }
            $user['is_active'] = 1;
            $user->save();
        }
        return view('website.user.account_active',$data);
    }
}



