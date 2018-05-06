<?php

namespace App\Http\Controllers\website;

use App\Category;
use App\NewApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubmittedAppController extends Controller
{
    public function index(Request $request)
    {
        $data['menu']="Submitted App";
        session()->forget('SESS_APP');
        $data['user']= session()->get('SESS_USER');
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();
      //  $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();
       // $data['submitted_app'] = NewApp::with('Screenshot')->where('userid',$data['user']['id'])->where('step','>=','1')->orderBy('id','DESC')->Paginate(8);
        $data['submitted_app'] = NewApp::with('Screenshot')->where('userid',$data['user']['id'])->where('app_status','approved')->orderBy('id','DESC')->Paginate(8);
        return view('website.submitted_app',$data);
    }

    public function destroy($id)
    {
        $newapp = NewApp::with('Screenshot')->findOrFail($id);

        if(isset($newapp['Screenshot'])){
            foreach ($newapp['Screenshot'] as $img){
                $img->delete();
                if(file_exists($img->image)) {
                   unlink($img->image);
                 }
            }
        }

        $newapp->delete();

        \Session::flash('danger','App has been deleted successfully!');
        return redirect('submitted_app');
    }
}
