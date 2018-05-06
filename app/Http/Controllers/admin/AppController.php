<?php

namespace App\Http\Controllers\admin;

use App\NewApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data=[];
        $data['mainmenu'] = "";
        $data['menu']="App";
        $data['app'] = NewApp::all();
        return view('admin.app.index', $data);
    }

    public function show($id)
    {
        $data=[];
        $data['mainmenu'] = "";
        $data['menu']="App";
        $data['app'] = NewApp::findorFail($id);
        return view('admin.app.view',$data);
    }
}
