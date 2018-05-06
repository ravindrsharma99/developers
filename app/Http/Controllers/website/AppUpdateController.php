<?php

namespace App\Http\Controllers\website;

use App\Category;
use App\NewApp;
use App\Screenshot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppUpdateController extends Controller
{
    public function step1_edit($id)
    {
        $app = NewApp::findorFail($id);
        $data = [];
        $data['step1_app'] = $app;
        $updatingVersion = $app->getUpdatingVersion();

        if($updatingVersion){
            return redirect('step1/'. $updatingVersion->id);
        }
        
        $data['menu']="";
        
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();

        $user= session()->get('SESS_USER');

        if ($data['step1_app']['userid'] != $user->id){
            return redirect()->back();
        }

        return view('website.appupdate.step1',$data);
    }

    public function step1_update(Request $request,$id)
    {
        $this->validate($request, [
            'app_name' => 'required',
            'upload_apk' => 'max:512000',
        ]);

        if($request['upload_apk'] != "") {
            $apk_ext = $request['upload_apk']->getClientOriginalExtension();
            if ($apk_ext == 'apk') {
            } else {
                return back()->withInput()->withErrors(['upload_apk' => 'The upload apk must be a file of type: apk.']);
            }
        }

        if($request['upload_apk_icon'] != "") {
            $apk_icon_ext = $request['upload_apk_icon']->getClientOriginalExtension();
            if ($apk_icon_ext == 'jpeg' || $apk_icon_ext == 'jpg' || $apk_icon_ext == 'bmp' || $apk_icon_ext == 'png') {
            } else {
                return back()->withInput()->withErrors(['upload_apk_icon' => 'The upload apk icon must be a file of type: jpeg, bmp, png.']);
            }
        }

        $step1_app = NewApp::findorFail($id);

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

        if($step1_app->isSubVersion()){
            $step1_app->update($input);
            return redirect('step2/'. $step1_app->id);
        }
        else{
            // create new subversion for current app
            $subVersion = $step1_app->createSubVersion();
            $subVersion->update($input);
            return redirect('step2/'. $subVersion->id);
        }
    }


    public function step2_edit($id)
    {
        $data=[];
        $data['menu']="";
        $data['step2_app'] = NewApp::findorFail($id);
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();

        $user= session()->get('SESS_USER');

        if ($data['step2_app']['userid'] != $user->id){
            return redirect()->back();
        }

        return view('website.appupdate.step2', $data);
    }

    public function step2_update(Request $request,$id)
    {
        $step2_app = NewApp::findorFail($id);
        $minVersionCode = $step2_app->version_code;
        $parentApp = $step2_app->getParentApp();
        if($parentApp){
            $minVersionCode = $parentApp->version_code + 1;
        }
        $this->validate($request, [
            'version_number' => 'required',
            'category' => 'required',
            'price' => 'required',
            'support_email' => 'email',
            'company' => 'required',
            'contact_email' => 'email',
            'description' => 'required|min:100',
            'version_code' => 'required|numeric|min:'. $minVersionCode,
            'package_id' => 'required'
        ]);

        $input = $request->all();

        if($step2_app['step'] != '2' && $step2_app['step'] != '3' && $step2_app['step'] != '4'){
            $input['step'] = "2";
        }

        $step2_app->update($input);

        return redirect('step3/'.$id);
    }

    public function step3_edit($id)
    {
        $data=[];
        $data['menu']="";
        $data['step3_app'] = NewApp::findorFail($id);
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();
        $data['image'] = Screenshot::where('app_id',$id)->get();

        $user= session()->get('SESS_USER');

        if ($data['step3_app']['userid'] != $user->id){
            return redirect()->back();
        }

        if($data['step3_app']['step'] == '2' || $data['step3_app']['step'] == '3' || $data['step3_app']['step'] == '4'){
            return view('website.appupdate.step3',$data);
        }
        else{
            return redirect()->back();
        }

    }

    public function step3_update(Request $request,$id)
    {
        $step3_app = NewApp::findorFail($id);

        $input_step3 = $request->all();

        if($step3_app['step'] != '3' && $step3_app['step'] != '4'){
            $input_step3['step'] = "3";
        }

        $step3_app->update($input_step3);

        return redirect('step4/'.$id);
    }

    public function step4_edit($id)
    {
        $data=[];
        $data['menu']="";
        $data['step4_app'] = NewApp::findorFail($id);
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();

        $user= session()->get('SESS_USER');

        if ($data['step4_app']['userid'] != $user->id){
            return redirect()->back();
        }

        if($data['step4_app']['step'] == '3' || $data['step4_app']['step'] == '4'){
            return view('website.appupdate.step4',$data);
        }
        else{
            return redirect()->back();
        }

    }

    public function step4_update(Request $request,$id)
    {
        $step4_app = NewApp::findorFail($id);

        $input = $request->all();

        if($request['terms_agree'] == "on"){
            $input['terms_agree'] = "1";
        }

        if($step4_app['step'] != '4'){
            $input['step'] = "4";
        }
        $input['update_status'] = 'success';
        $input['app_status'] = 'pending';
        $step4_app->update($input);

        return redirect('/submitted_app');
    }


    public function app_detail($id)
    {
        $data=[];
        $data['menu']="";
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();
        $data['user']= session()->get('SESS_USER');
        $data['app_detail'] = NewApp::findorFail($id);
        $data['image'] = Screenshot::where('app_id',$id)->get();

        $data['releted_app'] = NewApp::where('userid',$data['user']['id'])->where('category',$data['app_detail']['category'])->where('id','!=',$id)->get();

        if ($data['app_detail']['userid'] != $data['user']->id){
            return redirect()->back();
        }

        return view('website.app_detail',$data);
    }

    public function screenshotimage(Request $request)
    {

        if ($photo = $request->file('image')) {
            $root = base_path() . '/public/resource/App/screenshot/';
            $name = str_random(20).".".$photo->getClientOriginalExtension();
            if (!file_exists($root)) {
                mkdir($root, 0777, true);
            }

            $image_path = "resource/App/screenshot/".$name;
            $photo->move($root,$name);

            $input['app_id'] = $request['app_id'];
            $input['image'] = $image_path;
            $image = Screenshot::create($input);
        }
        return $image->id;


    }
}
