<?php

namespace App\Http\Controllers\admin;

use App\AppUser;
use App\Http\Controllers\Controller;
use App\Point_History;
use Illuminate\Http\Request;
use App\AppComment;

class ReviewController extends Controller
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

    public function edit(Request $request, AppComment $review)
    {
        $data=[];
        $data['menu']="AppUser";
        $data['mainmenu'] = "Users";
        $data['comment'] = $review;
        return view('admin.reviews.edit', $data);
    }

    public function update(Request $request, AppComment $review)
    {
        $this->validate($request, [
            'comment' => 'required',
            'rating' => 'required|numeric|max:5|min:1',
        ]);

        $data = $request->all();
        $review->update($data);

        $app = $review->app->updateAverageRating();

        \Session::flash('success','Review has been updated successfully!');
        return redirect()->route('admin.apps.detail', ['id' => $review->app->userid, 'appid' => $review->app_id]);
    }

    public function destroy(Request $request, AppComment $review)
    {
        $review->delete();
        $app = $review->app->updateAverageRating();
        \Session::flash('danger','Review has been deleted successfully!');
        return redirect()->route('admin.apps.detail', ['id' => $review->app->userid, 'appid' => $review->app_id]);
    }

}
