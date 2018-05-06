<?php
namespace App\Http\Controllers\website;
use App\Citie;
use App\Countrie;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $data['menu']="Home";
        if (session()->get('SESS_USER')){
            return redirect('/dashboard');
        }
        $data['country'] = Countrie::pluck('name','id')->all();
        $data['state'] = State::pluck('name','id')->all();
        $data['city'] = Citie::pluck('name','id')->all();
        return view('website.user.login',$data);
    }
}