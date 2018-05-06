<?php

namespace App\Http\Controllers\admin;

use App\AppUser;
use App\Http\Controllers\Controller;
use App\NewApp;
use App\WebUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\WithdrawRequest;
use App\AppDownload;
use App\Setting;

use Mail;
use App\Mail\RejectedAppEmail;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['mainmenu'] = "";
        $data['menu'] = "Dashboard";
        $data['total_web_user'] = WebUser::count();
        $data['total_app_user'] = AppUser::count();
        $data['total_approved_app'] = NewApp::where('step','4')->where('app_status','approved')->count();
        $data['total_pending_app'] = NewApp::where('step','4')->where('app_status','pending')->count();
        $data['total_rejected_app'] = NewApp::where('step','4')->where('app_status','rejected')->count();

        $data['total_download_app'] = AppDownload::count();
        $data['current_balance'] = Setting::getSetting('current_balance');
        return view('admin.dashboard',$data);
    }

    public function app_approved()
    {
        $data['mainmenu'] = "WebUser";
        $data['menu'] = "Approved";
        $data['app'] = NewApp::where('step','4')->where('app_status','approved')->get();
        return view('admin.app_status',$data);
    }

    public function app_pending()
    {
        $data['mainmenu'] = "WebUser";
        $data['menu'] = "Pending";
        $data['app'] = NewApp::where('step','4')
        ->where('app_status','pending')
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.app_status',$data);
    }

    public function app_rejected()
    {
        $data['mainmenu'] = "WebUser";
        $data['menu'] = "Rejected";
        $data['app'] = NewApp::where('step','4')->where('app_status','rejected')->get();
        return view('admin.app_status',$data);
    }

    public function update_status($id,$vid)
    {
        $status = NewApp::findOrFail($vid);
        $input['app_status'] = $id;
        if($id != 'rejected'){
        }
        return '';
    }

    public function remark_status(Request $request,$id)
    {
        $status = NewApp::findOrFail($id);
        $input['remark'] = $request['remark'];
        $input['app_status'] = "rejected";
        $status->update($input);
        
        if($status->developer){
            // send email to inform to developer
            Mail::to($status->developer->email)->send(new RejectedAppEmail($status));
        }
        
        return redirect()->back();
    }

    public function remark_status_approved($id)
    {
        $status = NewApp::findOrFail($id);
        $parentApp = $status->getParentApp();
        if(!$parentApp){
            // this's new version
            $input['app_status'] = "approved";
            $status->update($input);
        }
        else{
            // step 1: create a old version for current app
            $parentApp->releaseNewVersion($status);
        }

        return redirect()->back();
    }

    public function remark_status_pending($id)
    {
        $status = NewApp::findOrFail($id);
        $input['app_status'] = "pending";
        $status->update($input);
        return redirect()->back();
    }

    public function assign(Request $request)
    {
        $newapp = NewApp::findorFail($request['id']);
        $newapp['app_status']="pending";
        $newapp->update($request->all());
        return $request['id'];
    }

    public function unassign(Request $request)
    {
        $newapp = NewApp::findorFail($request['id']);
        $newapp['app_status']="approved";
        $newapp->update($request->all());
        return $request['id'];
    }
}
