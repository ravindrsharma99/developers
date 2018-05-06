<?php

namespace App\Http\Controllers\admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $data=[];
        $data['mainmenu'] = "";
        $data['menu']="User";
        //$data['role'] = $name;
        $data['list'] = User::all();
        return view('admin.users.details', $data);
    }


    public function create(Request $id)
    {
        $data=[];
        $data['mainmenu'] = "";
        $data['menu']="User";
        $data['user'] = User::find($id);// get all user data to check user['role']

        return view("admin.users.add",$data);
    }



    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',

        ]);
        $input = $request->all();
        $user = new User($input);
        $user->save();
        \Session::flash('success', 'User has been inserted successfully!');
        return redirect('admin/users');
    }


    public function show($id)
    {
        $data=[];
        $data['mainmenu'] = "";
        //$data['role'] = $name;
        $data['menu']="User";
        $data['user'] = User::findorFail($id);
        return view('admin.users.view',$data);
    }


    public function edit($id)
    {
        $data=[];

        //$data['role'] = $name;
        $data['menu']="User";
        $data['mainmenu'] = "";
        $data['user'] = User::findorFail($id);
        return view('admin.users.edit',$data);
    }


    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'password' => 'confirmed',

        ]);

        if(!empty($request['password'])){
        }
        else{
            unset($request['password']);
        }
        
        $input = $request->all();
        $user = User::findorFail($id);
        $user->update($input);
        \Session::flash('success','User has been updated successfully!');
        return redirect('admin/users/'.$id."/edit");
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        //$role = $name;
        \Session::flash('danger','User has been deleted successfully!');
        return redirect('admin/users');
    }


}
