<?php

namespace App\Http\Controllers\website;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $data['menu']="My Payment";
        session()->forget('SESS_APP');
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();
       // $data['user']= session()->get('SESS_USER');
      //  $data['latest_pending_app'] = NewApp::with('Screenshot')->where('userid',$data['user']['id'])->where('step','>=','2')->where('app_status','pending')->orderBy('id','DESC')->limit(5)->get();
        return view('website.mypayment',$data);
    }

    public function payment_update(Request $request)
    {
//        $data['menu']="My Payment";
//        return view('website.mypayment',$data);
    }
}
