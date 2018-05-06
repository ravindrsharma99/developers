<?php

namespace App\Http\Controllers\website;

use App\Category;
use App\NewApp;
use App\Screenshot;
use App\Http\Controllers\Controller;
use App\Staticpage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NewAppController extends Controller
{
    public function Step1_view(Request $request)
    {
        $data['menu']="New App";

       $data['step1'] = session()->get('SESS_APP');
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();

        if(isset($data['step1'])){
            $data['image'] = NewApp::where('id',$data['step1']['id'])->first();
        }
        return view('website.step1',$data);
    }

    public function step1_create(Request $request)
    {
        $this->validate($request, [
            'app_name' => 'required',
            'upload_apk' => 'required|max:512000',
            'upload_apk_icon' => 'required',
        ]);

        $apk_ext=$request['upload_apk']->getClientOriginalExtension();
        if($apk_ext == 'apk')
        {
        }
        else{
            return back()->withInput()->withErrors(['upload_apk' => 'The upload apk must be a file of type: apk.']);
        }

        $apk_icon_ext=$request['upload_apk_icon']->getClientOriginalExtension();
        if($apk_icon_ext == 'jpeg' || $apk_icon_ext == 'jpg' || $apk_icon_ext == 'bmp' || $apk_icon_ext == 'png')
        {
        }
        else{
            return back()->withInput()->withErrors(['upload_apk_icon' => 'The upload apk icon must be a file of type: jpeg, bmp, png.']);
        }

        $input = $request->all();

        if($photo = $request->file('upload_apk'))
        {
            $root = base_path() . '/public/resource/App/';
            $name = str_random(20).".".$photo->getClientOriginalExtension();
            if (!file_exists($root)) {
                mkdir($root, 0777, true);
            }
            $image_path = "resource/App/".$name;
            $photo->move($root,$name);
            $input['file'] = $image_path;
        }

        if($photo1 = $request->file('upload_apk_icon'))
        {
            $root1 = base_path() . '/public/resource/App/Icon/';
            $name1 = str_random(20).".".$photo1->getClientOriginalExtension();
            if (!file_exists($root1)) {
                mkdir($root1, 0777, true);
            }
            $image_path1 = "resource/App/Icon/".$name1;
            $photo1->move($root1,$name1);
            $input['apk_icon'] = $image_path1;
        }

        $data['user']= session()->get('SESS_USER');

        $input['userid'] = $data['user']['id'];
        $input['step'] = "1";

        $app=NewApp::create($input);

        session(['SESS_APP' => $app]);
        session()->get('SESS_APP');
        return redirect('step2');
    }

    public function Step2_view(Request $request)
    {
        $data['menu']="New App";
        $data['step2'] = session()->get('SESS_APP');
        $data['newapp'] = NewApp::where('id',$data['step2']['id'])->first();

        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();
        if($data['newapp']['step'] >= '1'){
            return view('website.step2',$data);
        }
        else{
            return redirect()->back();
        }

    }

    public function step2_update(Request $request)
    {
        $data['app']= session()->get('SESS_APP');
        $this->validate($request, [
            'version_number' => 'required',
            'category' => 'required',
            'price' => 'required',
            'support_email' => 'required|email',
            'company' => 'required',
            'contact_email' => 'required|email',
            'description' => 'required|min:100',
            'version_code' => 'required|numeric',
            'package_id' => 'required'
        ]);

        if(isset($data['app'])) {
            $step2_update = NewApp::findorFail($data['app']['id']);

            $input = $request->all();

            $input['id'] = $data['app']['id'];

            $input['app_name'] = $data['app']['app_name'];

            $input['userid'] = $data['app']['userid'];

            $input['step'] = "2";

            $step2_update->update($input);
        }
        else{
            return redirect()->back();
        }
       //return $request->session()->push('SESS_APP', $input);

        session(['SESS_APP' => $input]);

        return redirect('/step3');
    }

    public function Step3_view(Request $request)
    {
        $data['menu']="New App";
        $data['step3'] = session()->get('SESS_APP');
        $data['image'] = Screenshot::where('app_id',$data['step3']['id'])->get();
        $data['newapp'] = NewApp::where('id',$data['step3']['id'])->first();
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();

        if($data['newapp']['step'] >= '2'){
            return view('website.step3',$data);
        }
        else{
            return redirect()->back();
        }


    }

    public function step3_destroy_image($id)
    {
        $data['menu']="New App";
        $img = Screenshot::findOrFail($id);
        $img->delete();
        return redirect('/step3');
    }

    public function step3_update(Request $request)
    {
        $data['app']= session()->get('SESS_APP');

        if(isset($data['app'])) {
            $input = $request->all();

            $step3_update = NewApp::findorFail($data['app']['id']);

            $input_step3 = $request->all();

            $input_step3['id'] = $data['app']['id'];

            $input_step3['step'] = "3";

            $step3_update->update($input_step3);
        }
        else{
            return redirect()->back();
        }
        session(['SESS_APP' => $input_step3]);
        return redirect('/step4');
    }

    public function Step4_view(Request $request)
    {
        $data['menu']="New App";
        $data['app']= session()->get('SESS_APP');
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();
        $data['newapp'] = NewApp::where('id',$data['app']['id'])->first();

        if($data['newapp']['step'] >= 3){
            return view('website.step4',$data);
        }
        else{
            return redirect()->back();
        }
    }

    public function step4_update(Request $request)
    {
        $data['app']= session()->get('SESS_APP');

        if(isset($data['app'])){
            $step4_update = NewApp::findorFail($data['app']['id']);

            $input = $request->all();

            $input['id'] = $data['app']['id'];

            $input['step'] = "4";

            if($request['terms_agree'] == "on"){
                $input['terms_agree'] = "1";
            }

            $step4_update->update($input);
        }
        else{
            return redirect()->back();
        }

        session()->forget('SESS_APP');

        \Session::flash('success','Your App is under review');
        return redirect('/submitted_app');
    }

    public function search(Request $request)
    {
        //return "ok";
        $data['menu'] = 'Search';
        $data['keyword'] = $request['keyword'];
        session()->forget('SESS_APP');
        $data['user']= session()->get('SESS_USER');
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();

        if($request['category'] != null){
            $data['app_search'] = NewApp::has('Category')->with(['Category'])->where('userid',$data['user']['id'])->where('app_name','like','%'.$request['keyword'].'%')->where('category',$request['category'])->Paginate(8);
        }
        else{
            $data['app_search'] = NewApp::has('Category')->with(['Category'])->where('userid',$data['user']['id'])->where('app_name','like','%'.$request['keyword'].'%')->Paginate(8);
        }


        return view('website.search', $data);
    }

    public function terms(Request $request)
    {
        $data['menu'] = 'Terms';
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();
        $data['terms'] = Staticpage::where('id','1')->first();
        return view('website.terms', $data);
    }
}
