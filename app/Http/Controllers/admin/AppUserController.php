<?php

namespace App\Http\Controllers\admin;

use App\AppUser;
use App\Http\Controllers\Controller;
use App\Point_History;
use Illuminate\Http\Request;
class AppUserController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data=[];
        $data['mainmenu'] = "Users";
        $data['menu']="AppUser";
        $data['appusers'] = AppUser::all();
        return view('admin.appusers.index', $data);
    }

    public function create()
    {
        $data=[];
        $data['menu']="AppUser";
        $data['mainmenu'] = "Users";
        return view("admin.appusers.add",$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:app_users,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'image' => 'required|mimes:jpeg,jpg,bmp,png',
            'phone'=>'required',
            'status'=>'required',
        ]);
        $input = $request->all();

        if(empty($request['address']))
        {
            $input['address'] = "";
        }
        else{
            $input['address'] = $request['address'];
        }

        if($photo = $request->file('image'))
        {
            $root = base_path() . '/public/resource/Appuser/' ;
            $name = str_random(20).".".$photo->getClientOriginalExtension();
            if (!file_exists($root)) {
                mkdir($root, 0777, true);
            }

            $image_path = "resource/Appuser/".$name;
            $photo->move($root,$name);
            $input['image'] = $image_path;
        }

        $appuser=AppUser::create($input);

        \Session::flash('success', 'AppUser has been inserted successfully!');
        return redirect('admin/appusers');
    }

    
    public function show($id)
    {
        $data=[];
        $data['menu']="AppUser";
        $data['mainmenu'] = "Users";
        $data['appuser'] = AppUser::findorFail($id);
        return view('admin.appusers.view',$data);
    }

    public function edit($id)
    {
        $data=[];
        $data['menu']="AppUser";
        $data['mainmenu'] = "Users";
        $data['appuser'] = AppUser::findorFail($id);
        return view('admin.appusers.edit',$data);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:app_users,email,'.$id.',id',
            'password' => 'confirmed',
            'image' => 'mimes:jpeg,jpg,bmp,png',
            'phone'=>'required',
            'status'=>'required',
        ]);

        $appuser = AppUser::findorFail($id);

        $input = $request->all();

        if(!empty($request['password'])){
        }
        else{
            unset($request['password']);
        }

        if(empty($request['address']))
        {
            $input['address'] = "";
        }
        else{
            $input['address'] = $request['address'];
        }

        if($photo = $request->file('image'))
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
            $input['image'] = "resource/Appuser/".$name;
        }

        $appuser->update($input);

        \Session::flash('success','AppUser has been updated successfully!');
        return redirect('admin/appusers');
    }

    public function destroy($id)
    {
        $appuser = AppUser::findOrFail($id);

        $appuser->delete();
        \Session::flash('danger','AppUser has been deleted successfully!');
        return redirect('admin/appusers');
    }

}
