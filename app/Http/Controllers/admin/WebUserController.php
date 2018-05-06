<?php

namespace App\Http\Controllers\admin;

use App\Citie;
use App\Countrie;
use App\NewApp;
use App\State;
use App\WebUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebUserController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data=[];
        $data['mainmenu'] = "WebUser";
        $data['menu']="WebUser";
        $data['webusers'] = WebUser::all();
        return view('admin.webusers.index', $data);
    }

    public function create()
    {
        $data=[];
        $data['menu']="WebUser";
        $data['mainmenu'] = "WebUser";
        $data['mode'] = 'add';
        $data['country'] = Countrie::pluck('name','id')->all();
        $data['state'] = State::pluck('name','id')->all();
        $data['city'] = Citie::pluck('name','id')->all();
        return view("admin.webusers.add",$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:web_users,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'country'=>'required',
            'city'=>'required',
            'state'=>'required',
            'companyname'=>'required',
            'status'=>'required',
        ]);
        $input = $request->all();

        $webuser=WebUser::create($input);

        \Session::flash('success', 'Manage Developers has been inserted successfully!');
        return redirect('admin/webusers');
    }

    public function show($id)
    {
        $data=[];
        $data['menu']="WebUser";
        $data['mainmenu'] = "WebUser";
        $data['webusers'] = WebUser::findorFail($id);

        $data['app'] = NewApp::where('userid',$id)->get();
        return view('admin.webusers.view',$data);
    }

    public function app_show($id,$appid)
    {
        $data=[];
        $data['menu']="WebUser";
        $data['mainmenu'] = "WebUser";
        $data['app'] = NewApp::with('Screenshot')->findorFail($appid);
        return view('admin.webusers.app_view',$data);
    }

    public function edit($id)
    {
        $data=[];
        $data['menu']="WebUser";
        $data['mainmenu'] = "WebUser";
        $data['mode'] ='edit';
        $data['webuser'] = WebUser::findorFail($id);
        $data['country'] = Countrie::pluck('name','id')->all();
        $data['state'] = State::where('country_id',$data['webuser']['country'])->pluck('name','id')->all();
        $data['city'] = Citie::where('state_id',$data['webuser']['state'])->pluck('name','id')->all();
        return view('admin.webusers.edit',$data);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:web_users,email,'.$id.',id',
            'password' => 'confirmed',
            'country'=>'required',
            'city'=>'required',
            'state'=>'required',
            'companyname'=>'required',
            'status'=>'required',
        ]);

        $webuser = WebUser::findorFail($id);

        $input = $request->all();

        if(!empty($request['password'])){
        }
        else{
            unset($request['password']);
        }

        $webuser->update($input);

        \Session::flash('success','Manage Developers has been updated successfully!');
        return redirect('admin/webusers');
    }

    public function destroy($id)
    {
        $webuser = WebUser::findOrFail($id);

        $webuser->delete();
        \Session::flash('danger','Manage Developers has been deleted successfully!');
        return redirect('admin/webusers');
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
