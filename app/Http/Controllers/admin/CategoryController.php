<?php

namespace App\Http\Controllers\admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data=[];
        $data['mainmenu'] = "";
        $data['menu']="Category";
        $data['category'] = Category::all();
        return view('admin.category.index', $data);
    }

    public function create()
    {
        $data=[];
        $data['menu']="Category";
        $data['mainmenu'] = "";
        return view("admin.category.add",$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status'=>'required',
        ]);

        $input = $request->all();

        $category=Category::create($input);

        \Session::flash('success', 'Category has been inserted successfully!');
        return redirect('admin/category');
    }


    public function show($id)
    {
        $data=[];
        $data['menu']="Category";
        $data['mainmenu'] = "";
        $data['category'] = Category::findorFail($id);
        return view('admin.category.view',$data);
    }

    public function edit($id)
    {
        $data=[];
        $data['menu']="Category";
        $data['mainmenu'] = "";
        $data['category'] = Category::findorFail($id);
        return view('admin.category.edit',$data);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status'=>'required',
        ]);

        $category = Category::findorFail($id);

        $input = $request->all();

        $category->update($input);

        \Session::flash('success','Category has been updated successfully!');
        return redirect('admin/category');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();
        \Session::flash('danger','Category has been deleted successfully!');
        return redirect('admin/category');
    }
}
