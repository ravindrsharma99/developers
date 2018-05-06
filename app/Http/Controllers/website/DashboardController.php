<?php

namespace App\Http\Controllers\website;
use App\Category;
use App\NewApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['menu']="Web Dashboard";
        session()->forget('SESS_APP');
        $data['user']= session()->get('SESS_USER');
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();
       // $data['latest_app'] = NewApp::with('Screenshot')->where('userid',$data['user']['id'])->where('step','>=','2')->orderBy('id','DESC')->limit(5)->get();
        $data['latest_app'] = NewApp::with('Screenshot')->where('userid',$data['user']['id'])->where('app_status','approved')->orderBy('id','DESC')->limit(5)->get();
      //  $data['latest_pending_app'] = NewApp::with('Screenshot')->where('userid',$data['user']['id'])->where('step','>=','1')->where('app_status','pending')->orderBy('id','DESC')->limit(5)->get();
        $data['latest_pending_app'] = NewApp::with('Screenshot')->where('userid',$data['user']['id'])->where('step','>=','1')->where('app_status','pending')->orderBy('id','DESC')->get();
        $data['latest_approved_app'] = NewApp::with('Screenshot')->where('userid',$data['user']['id'])->where('app_status','approved')->orderBy('id','DESC')->get();
        $data['latest_rejected_app'] = NewApp::with('Screenshot')->where('userid',$data['user']['id'])->where('app_status','rejected')->orderBy('id','DESC')->get();

        $data['top_latest_pending_app'] = NewApp::with('Screenshot')->where('userid',$data['user']['id'])->where('step','>=','1')->where('app_status','pending')->orderBy('id','DESC')->limit(5)->get();
        $data['top_latest_approved_app'] = NewApp::with('Screenshot')->where('userid',$data['user']['id'])->where('app_status','approved')->orderBy('id','DESC')->limit(5)->get();
        $data['top_latest_rejected_app'] = NewApp::with('Screenshot')->where('userid',$data['user']['id'])->where('app_status','rejected')->orderBy('id','DESC')->limit(5)->get();
        return view('website.dashboard',$data);
    }
}