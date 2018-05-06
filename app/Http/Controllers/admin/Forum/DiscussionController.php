<?php

namespace App\Http\Controllers\admin\Forum;

use App\ChatterDiscussion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data=[];
        $data['mainmenu'] = "forums";
        $data['menu']= "Forum Discussions";
        $data['appusers'] = ChatterDiscussion::orderBy('id', 'DESC')
        ->get();

        return view('admin.forums.discussions.index', $data);
    }

    public function create()
    {
        $data=[];
        $data['menu']= "Forum Discussions";
        $data['mainmenu'] = "forums";
        return view("admin.forums.discussions.add", $data);
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

        $appuser = ChatterDiscussion::create($input);

        \Session::flash('success', 'ChatterDiscussion has been inserted successfully!');
        return redirect('admin/appusers');
    }

    
    public function show($id)
    {
        $data=[];
        $data['menu']="Forum Discussions";
        $data['mainmenu'] = "forums";
        $discuss = ChatterDiscussion::findorFail($id);
        $data['discuss'] = $discuss;
        $data['posts'] = $discuss->getPosts();
        return view('admin.forums.discussions.posts', $data);
    }

    public function edit($id)
    {
        $data=[];
        $data['menu']="Forum Discussions";
        $data['mainmenu'] = "forums";
        $data['discuss'] = ChatterDiscussion::findorFail($id);

        $categories = \App\ChatterCategory::all();
        $categoriesForm = [];
        foreach($categories as $c){
            $categoriesForm[$c->id] = $c->getTitle();
        }
        $data['categories'] = $categoriesForm;

        return view('admin.forums.discussions.edit',$data);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'title' => 'required',
            'chatter_category_id' => 'required',
        ]);

        $appuser = ChatterDiscussion::findorFail($id);

        $input = $request->all();

        $appuser->update($input);
           
        \Session::flash('success','Discussion has been updated successfully!');
        return redirect('admin/forums');
    }

    public function destroy($id)
    {
        $discuss = ChatterDiscussion::findOrFail($id);

        $discuss->delete();
        // remove all posts from this discussion
        \App\ChatterPost::where('chatter_discussion_id', $discuss->id)
        ->delete();
        
        \Session::flash('danger','Discussion has been deleted successfully!');
        return redirect('admin/forums');
    }

    public function deletePost($id){
        $post = \App\ChatterPost::findOrFail($id);
        $post->delete();
        \Session::flash('danger','Post has been deleted successfully!');
        return redirect()->route('admin.forums.show', ['id' => $post->chatter_discussion_id]);
    }
}
