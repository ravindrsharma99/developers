<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Article;
use App\Models\Post;
use App\Mail\ForgotPasswordEmail;
use App\Mail\UserRegisterEmail;
use App\MobiService;
use App\AppUserToken as UserToken;
use App\AppUser as User;
use Mail;
use Illuminate\Support\Facades\Crypt;
use App\Category;
use App\NewApp;
use App\WebUser as Developer;

if(!function_exists('j')){
    function j($data)
    {
        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }
}

class ApiController extends BaseController
{
    public function __construct(){
        config(['auth.defaults.guard' => 'dmobi']);
    }

    public function index(){
        return [
            'status' => true,
        ];
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return [
                'status' => false,
                'message' => $errors[0],
                'errors' => $errors,
            ];
        }
        $email = $request->input('email');
        $password = $request->input('password');
    
        if (auth()->attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            if ($user->status == 'suspended') {
                return [
                    'status' => false,
                    'message' => "This's account is no longer active. Please contact with admin.",
                ];
            }
            
            $token = UserToken::createToken();
            return j([
                'status' => true,
                'user' => auth()->user(),
                'token' => $token,
            ]);
        } else {
            return [
                'status' => false,
                'message' => 'Email or password is invalid.',
            ];
        }
    }

    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return [
                'status' => false,
                'message' => $errors[0],
                'errors' => $errors,
            ];
        }
        $email = $request->input('email');
        $user = User::where('email', $email)
            ->first();
        if (!$user) {
            return [
                'status' => false,
                'message' => trans('message.no_user_match_with_this_email'),
            ];
        }
    
        $newPassword = str_random(8);
        $user->password = $newPassword;
        $user->save();
    
        // send new password to this email
        Mail::to($email)->send(new ForgotPasswordEmail($user, $newPassword));
    
        return [
            'status' => true,
            'message' => trans('message.a_new_password_sent_to_your_email'),
        ];
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return [
                'status' => false,
                'message' => $errors[0],
                'errors' => $errors,
            ];
        }
    
        if ($request->input('password') != $request->input('confirm_password')) {
            return [
                'status' => false,
                'message' => 'Password is not matched.',
            ];
        }
    
        $data = $request->all();
        $password = $data['password'];
        $email = $data['email'];
    
        $checkEmail = User::where('email', $email)->first();
        if ($checkEmail) {
            return [
                'status' => false,
                'message' => trans('message.email_is_used'),
            ];
        }
    
        if ($request->hasFile('image')) {
            $path = $request->image->store('upload/images');
            $data['image'] = $path;
        }

        $data['fullname'] = $data['firstname'] . ' ' . $data['lastname'];

        $alias = str_slug($data['fullname']);
        // check if alias is exists then plus with id
        $check = User::where('alias', $alias)->first();
        if(!$check){
            $data['alias'] = $alias;
        }
    
        $user = User::create($data);
        if($check){
            $alias = $alias . '-' . $user->id;
            $user->alias = $alias;
            $user->save();
        }
    
        Mail::to($email)->send(new UserRegisterEmail($user));
    
        Auth::attempt(['email' => $email, 'password' => $password]);
        
        $token = UserToken::createToken($user);
        return j([
            'status' => true,
            'user' => $user,
            'token' => $token,
            'message' => trans('message.register_successfully'),
        ]);
    }

    public function socialLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'social_id' => 'required',
            'social_type' => 'required',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return [
                'status' => false,
                'message' => $errors[0],
                'errors' => $errors,
            ];
        }
    
        $socialSupports = ['google', 'facebook', 'mobichat', 'twitter'];
        $socialId = $request->input('social_id');
        $socialType = $request->input('social_type');
        if (!in_array($socialType, $socialSupports)) {
            return [
                'status' => false,
                'message' => 'Only support login social with google and facebook.',
            ];
        }
    
        // first check if a user with social id and social type
        $user = User::where($socialType . '_id', $socialId)->first();

        if ($user) {
            $token = UserToken::createToken($user);

            return [
                'status' => true,
                'user' => $user,
                'token' => $token,
            ];
        }
    
        // create new user
        // check if email is exists then map this social user with email user
        if ($request->input('email')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);
    
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return [
                    'status' => false,
                    'message' => $errors[0],
                    'errors' => $errors,
                ];
            }
    
            $email = $request->input('email');
            // find user with this email
            $user = User::where('email', $email)->first();
            if ($user) {
                $socialField = $socialType . '_id';
                $user->{$socialField} = $socialId;

                $user->save();
                $token = UserToken::createToken($user);
                
                return [
                    'status' => true,
                    'user' => $user,
                    'token' => $token,
                ];
            }
        }       
    
        // new user, create new
        $data = [
            'email' => $request->input('email'),
            'fullname' => $request->input('fullname'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'role' => 'user',
            'phone' => $request->input('phone'),
            'image' => $request->input('image'),
        ];

        $data[$socialType . '_id'] = $socialId;
    
        $user = User::create($data);
        // create feed to home page
        $token = UserToken::createToken($user);

        return j([
            'status' => true,
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function profile(Request $request){
        $user = auth()->user();

        return j([
            'user' => $user,
            'status' => true,
        ]);
    }

    public function logout(Request $request){
        auth()->logout();
        return [
            'status' => true,
            'message' => 'Logout success.',
        ];
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
            'new_password_confirm' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return [
                'status' => false,
                'message' => $errors[0],
                'errors' => $errors,
            ];
        }

        $data = $request->all();
        if ($data['new_password'] != $data['new_password_confirm']) {
            return [
                'status' => false,
                'message' => trans('message.new_password_is_not_matched'),
            ];
        }

        $user = auth()->user();
        $email = $user->email;
        $password = $data['password'];
        $newPassword = $data['new_password'];
        if (!Auth::guard('dmobi')->attempt(['email' => $email, 'password' => $password])) {
            return [
                'status' => false,
                'message' => trans('message.current_password_is_incorrect'),
            ];
        }
        $user->password = $newPassword;
        $user->save();
        return [
            'status' => true,
            'message' => trans('message.change_password_successfully'),
        ];
    }

    public function updateDeviceToken(Request $request){
        $validator = Validator::make($request->all(), [
            'device_token' => 'required',
            'device' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return [
                'status' => false,
                'message' => $errors[0],
                'errors' => $errors,
            ];
        }

        $userToken = auth()->token();
        // clean all user token with this device token
        UserToken::where('device_token', $request->input('device_token'))
        ->where('id', '<>', $userToken->id)
        ->delete();

        $userToken->device_token = $request->input('device_token');
        $userToken->device = $request->input('device');
        $userToken->save();
        return [
            'status' => true,
            'message' => trans('message.update_device_token_successfully'),
        ];
    }

    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            // 'image' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return [
                'status' => false,
                'message' => $errors[0],
                'errors' => $errors,
            ];
        }

        $data = $request->all();
        $email = $data['email'];

        $user = auth()->user();
        if ($user->email != $email) {
            $checkEmail = User::where('email', $email)->first();
            if ($checkEmail) {
                return [
                    'status' => false,
                    'message' => trans('message.email_is_used'),
                ];
            }
        }

        // check and upload image
        if($photo = $request->file('image')){
            $root = base_path() . '/public/resource/Appuser/' ;
            $name = str_random(20).".".$photo->getClientOriginalExtension();
            if (!file_exists($root)) {
                mkdir($root, 0777, true);
            }

            $image_path = "resource/Appuser/".$name;
            $photo->move($root, $name);
            $data['image'] = $image_path;
        }

        // check and upload image
        if($cover = $request->file('cover')){
            $root = base_path() . '/public/resource/Appuser/' ;
            $name = str_random(20).".".$cover->getClientOriginalExtension();
            if (!file_exists($root)) {
                mkdir($root, 0777, true);
            }

            $image_path = "resource/Appuser/".$name;
            $cover->move($root, $name);
            $data['cover'] = $image_path;
        }

        $data['fullname'] = $data['firstname'] . ' ' . $data['lastname'];
        $user->update($data);

        $newUser = User::find($user->id);

        return j([
            'status' => true,
            'user' => $newUser,
            'message' => trans('message.update_profile_successfully'),
        ]);
    }

    public function getUserDetail (Request $request, $id) {
        $profile = User::find($id);
        if(!$profile) {
            return [
                'status' => false,
                'message' => trans('message.user_not_found')
            ];
        }
        if(!$profile->image){
            $profile->image = User::DEFAULT_USER_IMAGE;
        }

        $user = auth()->user();
        $profile->setAttribute('is_following', $user->isFollowing($profile));
        return j([
            'user' => $profile,
            'status' => true
        ]);
    }

    public function users(Request $request){
        $users = User::all();
        return [
            'status' => true,
            'users' => $users
        ];
    }

    public function categories(Request $request){
        $categories = Category::where('status', Category::STATUS_ACTIVE)
        ->get();
        return [
            'status' => true,
            'categories' => $categories
        ];
    }

    public function getCategoryApps(Request $request, $id){
        $category = Category::find($id);
        if(!$category){
            return [
                'status' => false,
                'message' => trans('message.category_is_not_exists')
            ];
        }
        $apps = $category->getApps($request->all());

        return [
            'status' => true,
            'category' => $category,
            'apps' => $apps
        ];
    }

    public function topRatedApps(Request $request){
        $apps = NewApp::getTopRatedApps($request->all());
        return [
            'status' => true,
            'apps' => $apps
        ];
    }

    public function newestApps(Request $request){
        $apps = NewApp::getNewApps($request->all());
        return [
            'status' => true,
            'apps' => $apps
        ];
    }

    public function home(Request $request){
        $blocks = [];
        // top rated app, base on average rating
        $topRatedApps = NewApp::getTopRatedApps([
            'length' => 10
        ]);
        if($topRatedApps && $topRatedApps->count()){
            $blocks[] = [
                'title' => trans('message.top_rated_apps'),
                'apps' => $topRatedApps,
                'api' => 'apps/v/top-rated'
            ];
        }

        // newest app base on time upload
        $newApps = NewApp::getNewApps([
            'length' => 10
        ]);
        if($newApps && $newApps->count()){
            $blocks[] = [
                'title' => trans('message.newest_apps'),
                'apps' => $newApps,
                'api' => 'apps/v/newest'
            ];
        }

        $categoryHomeBlocks = Category::where('show_on_home_app', 1)
        ->where('status', 'active')
        ->get();

        foreach($categoryHomeBlocks as $category){
            $tmpApps = $category->getApps(['sort' => 'average_rating', 'length' => 10]);
            if(!empty($tmpApps) && $tmpApps->count()){
                $blocks[] = [
                    'title' => trans('message.top_app_in_category', ['title' => $category->name]),
                    'apps' => $tmpApps,
                    'api' => 'categories/' . $category->id . '/apps'
                ];
            }
        }
        
        if(auth()->check()){
            $user = auth()->user();
            $recentApps = $user->getRecentApps([
                'length' => 10
            ]);
            if(!empty($recentApps)){
                $blocks[] = [
                    'title' => trans('message.recent_apps'),
                    'apps' => $recentApps,
                    'api' => 'apps/v/recent'
                ];
            }
        }

        return [
            'status' => true,
            'blocks' => $blocks
        ];
    }

    public function appDetail(Request $request, $id){
        $app = NewApp::find($id);
        if(!$app) return [
            'status' => false,
            'message' => trans('message.app_is_not_found')
        ];

        if($app->status != 'active'){
            return [
                'status' => false,
                'message' => trans('message.app_is_no_longer_active')
            ];
        }

        $developer = Developer::find($app->userid);

        if(!$developer){
            return [
                'status' => false,
                'message' => trans('message.this_developer_is_no_longer_exists')
            ];
        }

        if($developer->status != 'active'){
            return [
                'status' => false,
                'message' => trans('message.this_developer_is_no_longer_active')
            ];
        }

        $relatedApp = $app->getRelatedApp([]);
        $sameFromDeveloper = $developer->getApps([]);
        
        $category = \App\Category::find($app->category);
        
        $data = [
            'status' => true,
            'app' => $app,
            'developer' => $developer,
            'category' => $category, 
            'blocks' => [
                [
                    'title' => trans('message.related_app'),
                    'apps' => $relatedApp,
                    'api' => 'apps/' . $app->id . '/related'
                ],
                [
                    'title' => trans('message.form_this_developer'),
                    'apps' => $sameFromDeveloper,
                    'api' => 'developers/' . $developer->id . '/apps'
                ],
            ],
            'comments' => $app->getComments(['length' => 5]),
            'screenshorts' => $app->getScreenshorts()
        ];

        // get comment of current user
        if(auth()->check()){
            $comment = $app->getCommentOfUser();
            if($comment){
                $data['comment'] = $comment;
            }

            $user = auth()->user();
            $user->viewApp($app);
        }

        return $data;
    }

    public function developerDetail(Request $request, $id){
        $developer = Developer::find($id);
        if(!$developer) return [
            'status' => false,
            'message' => trans('message.this_developer_is_no_longer_exists')
        ];
        if($developer->status != 'active'){
            return [
                'status' => false,
                'message' => trans('message.this_developer_is_no_longer_active')
            ];
        }

        return [
            'status' => true,
            'developer' => $developer,
            'blocks' => [
                [
                    'title' => trans('message.app_apps'),
                    'apps' => $developer->getApps(),
                    'api' => 'developers/' . $developer->id . '/apps'
                ]
            ]
        ];
    }

    public function appFromDeveloper(Request $request, $id){
        $developer = Developer::find($id);
        if(!$developer) return [
            'status' => false,
            'message' => trans('message.this_developer_is_no_longer_exists')
        ];
        if($developer->status != 'active'){
            return [
                'status' => false,
                'message' => trans('message.this_developer_is_no_longer_active')
            ];
        }

        $length = $request->query('length', 20);
        $start = $request->query('start', 0);

        $apps = $developer->getApps(['length' => $length, 'start' => $start]);
        

        return [
            'status' => true,
            'apps' => $apps
        ];
    }

    public function postComment(Request $request, $id){
        $app = NewApp::find($id);
        if(!$app) return [
            'status' => false,
            'message' => trans('message.app_is_not_found')
        ];

        if($app->status != 'active'){
            return [
                'status' => false,
                'message' => trans('message.app_is_no_longer_exists')
            ];
        }

        $validator = Validator::make($request->all(), [
            'comment' => 'required',
            'rating' => 'required',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return [
                'status' => false,
                'message' => $errors[0],
                'errors' => $errors,
            ];
        }

        $comment = $app->addComment(null, [
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating')
        ]);

        if($comment->is_update){
            return [
                'status' => true,
                'message' => trans('message.update_comment_successfully'),
                'comment' => $comment
            ];
        }

        return [
            'status' => true,
            'message' => trans('message.add_comment_successfully'),
            'comment' => $comment
        ];
    }

    public function getAppComments(Request $request, $id){
        $app = NewApp::find($id);
        if(!$app) return [
            'status' => false,
            'message' => trans('message.app_is_not_found')
        ];
        if($app->status != 'active'){
            return [
                'status' => false,
                'message' => trans('message.app_is_no_longer_exists')
            ];
        }

        $data = $request->all();

        $comments = $app->getComments($data);

        return [
            'status' => true,
            'comments' => $comments
        ];
    }

    public function myApps(Request $request){
        $user = auth()->user();

        $downloaded = \App\AppDownload::with(['app'])
        ->where('user_id' , $user->id)
        ->get();

        $apps = [];
        $appIndexs = [];
        foreach($downloaded as $d){
            if($d->app){
                if(!isset($appIndexs[$d->app->id])){
                    $apps[] = $d->app;
                    $appIndexs[$d->app->id] = true;
                }
            }
        }

        return [
            'status' => true,
            'apps' => $apps
        ];
    }

    public function getRecentApps(Request $request){
        $user = auth()->user();
        $apps = $user->getRecentApps($request->all());
        return [
            'status' => true,
            'apps' => $apps
        ];
    }

    public function search(Request $request){
        $keyword = $request->input('keyword');
        $length = $request->input('length', 20);
        $start = $request->input('start', 0);

        if(empty($keyword)) return [
            'status' => false,
            'message' => trans('message.keyword_is_required')
        ];

        $query = \App\NewApp::where('status', 'active')
        ->where(function($query) use($keyword){
            $query->orWhere('app_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('company', 'LIKE', '%'. $keyword . '%');
        });

        if($request->input('category_id')){
            $categoryId = (int) $request->input('category_id');
            if($categoryId){
                $query->where('category', $request->input('category_id'));
            }
        }

        $apps = $query->skip($start)
        ->take($length)
        ->get();
        
        return [
            'status' => true,
            'apps' => $apps
        ];
    }

    public function relatedApps(Request $request, $id){
        $app = NewApp::find($id);
        if(!$app) return [
            'status' => false,
            'message' => trans('message.app_is_not_found')
        ];
        if($app->status != 'active'){
            return [
                'status' => false,
                'message' => trans('message.app_is_no_longer_exists')
            ];
        }

        return [
            'status' => true,
            'apps' => $app->getRelatedApp()
        ];
    }
}