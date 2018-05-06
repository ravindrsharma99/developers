<?php

namespace App\Http\Controllers\admin;

use App\Staticpage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaticpageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit($id)
    {
        $data['mainmenu']="";
        $data['menu']="Staticpage";
        $data['id'] = $id;
        $data['staticpage'] = Staticpage::findOrFail($id);
        return view('admin.staticpage.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $staticpage = Staticpage::findOrFail($id);
        $input = $request->all();
        $staticpage->update($input);
        \Session::flash('success', 'Staticpage has been Updated successfully!');
        return redirect('admin/staticpage/'.$id.'/edit');
    }
}
