<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewApp extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'userid','file','version_number','category','price','support_email','app_name','company','contact_email','description','terms_agree','step','status','rate','apk_icon','app_status','amount','remark','paypal_id', 'total_comment', 'total_download', 'average_rating', 'total_view', 'version_code', 'package_id', 'is_update', 'parent_id', 'update_status'
    ];

    // update_status: draft|success

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    const STATUS_pending = 'pending';
    const STATUS_approved = 'approved';
    const STATUS_rejected = 'rejected';
    const STATUS_old_version = 'old_version';

    public static $app_status = [
        self::STATUS_pending => 'Pending',
        self::STATUS_approved => 'Approved',
        self::STATUS_rejected => 'Rejected'
    ];

    const Price_Please = '';
    const Price_Free = 'Free';
    const Price_Price = 'Price';

    public static $price = [
        self::Price_Please => 'Please select',
        self::Price_Free => 'Free',
        self::Price_Price => 'Price',
    ];

    public function Screenshot()
    {
        return $this->hasMany('App\Screenshot', 'app_id');
    }

    public function Category()
    {
        return $this->belongsTo('App\Category', 'category');
    }

    public function WebUser()
    {
        return $this->belongsTo('App\WebUser', 'userid');
    }

    public function developer()
    {
        return $this->belongsTo('App\WebUser', 'userid');
    }

    const Price_Please1 = '';
    const Price_amount1 = '$0.99';
    const Price_amount2 = '$1.99';
    const Price_amount3 = '$2.99';
    const Price_amount4 = '$3.99';
    const Price_amount5 = '$4.99';
    const Price_amount6 = '$5.99';
    const Price_amount7 = '$6.99';
    const Price_amount8 = '$7.99';
    const Price_amount9 = '$8.99';
    const Price_amount10 = '$9.99';
    const Price_amount11 = '$10.99';
    const Price_amount12 = '$11.99';
    const Price_amount13 = '$12.99';
    const Price_amount14 = '$13.99';
    const Price_amount15 = '$14.99';
    const Price_amount16 = '$15.99';
    const Price_amount17 = '$16.99';
    const Price_amount18 = '$17.99';
    const Price_amount19 = '$18.99';
    const Price_amount20 = '$19.99';
    const Price_amount21 = '$20.99';
    const Price_amount22 = '$21.99';
    const Price_amount23 = '$22.99';
    const Price_amount24 = '$23.99';
    const Price_amount25 = '$24.99';
    const Price_amount26 = '$25.99';
    const Price_amount27 = '$26.99';
    const Price_amount28 = '$27.99';
    const Price_amount29 = '$28.99';
    const Price_amount30 = '$29.99';
    const Price_amount31 = '$30.99';
    const Price_amount32 = '$31.99';
    const Price_amount33 = '$32.99';
    const Price_amount34 = '$33.99';
    const Price_amount35 = '$34.99';
    const Price_amount36 = '$35.99';
    const Price_amount37 = '$36.99';
    const Price_amount38 = '$37.99';
    const Price_amount39 = '$38.99';
    const Price_amount40 = '$39.99';
    const Price_amount41 = '$40.99';
    const Price_amount42 = '$41.99';
    const Price_amount43 = '$42.99';
    const Price_amount44 = '$43.99';
    const Price_amount45 = '$44.99';
    const Price_amount46 = '$45.99';
    const Price_amount47 = '$46.99';
    const Price_amount48 = '$47.99';
    const Price_amount49 = '$48.99';
    const Price_amount50 = '$49.99';
    const Price_amount51 = '$50.99';
    const Price_amount52 = '$51.99';
    const Price_amount53 = '$52.99';
    const Price_amount54 = '$53.99';
    const Price_amount55 = '$54.99';
    const Price_amount56 = '$55.99';
    const Price_amount57 = '$56.99';
    const Price_amount58 = '$57.99';
    const Price_amount59 = '$58.99';
    const Price_amount60 = '$59.99';
    const Price_amount61 = '$60.99';
    const Price_amount62 = '$61.99';
    const Price_amount63 = '$62.99';
    const Price_amount64 = '$63.99';
    const Price_amount65 = '$64.99';
    const Price_amount66 = '$65.99';
    const Price_amount67 = '$66.99';
    const Price_amount68 = '$67.99';
    const Price_amount69 = '$68.99';
    const Price_amount70 = '$69.99';
    const Price_amount71 = '$70.99';
    const Price_amount72 = '$71.99';
    const Price_amount73 = '$72.99';
    const Price_amount74 = '$73.99';
    const Price_amount75 = '$74.99';
    const Price_amount76 = '$75.99';
    const Price_amount77 = '$76.99';
    const Price_amount78 = '$77.99';
    const Price_amount79 = '$78.99';
    const Price_amount80 = '$79.99';
    const Price_amount81 = '$80.99';
    const Price_amount82 = '$81.99';
    const Price_amount83 = '$82.99';
    const Price_amount84 = '$83.99';
    const Price_amount85 = '$84.99';
    const Price_amount86 = '$85.99';
    const Price_amount87 = '$86.99';
    const Price_amount88 = '$87.99';
    const Price_amount89 = '$88.99';
    const Price_amount90 = '$89.99';
    const Price_amount91 = '$90.99';
    const Price_amount92 = '$91.99';
    const Price_amount93 = '$92.99';
    const Price_amount94 = '$93.99';
    const Price_amount95 = '$94.99';
    const Price_amount96 = '$95.99';
    const Price_amount97 = '$96.99';
    const Price_amount98 = '$97.99';
    const Price_amount99 = '$98.99';
    const Price_amount100 = '$99.99';

    public static $amount = [
        self::Price_Please1 => 'Please select',
        self::Price_amount1 => '$0.99',
        self::Price_amount2 => '$1.99',
        self::Price_amount3 => '$2.99',
        self::Price_amount4 => '$3.99',
        self::Price_amount5 => '$4.99',
        self::Price_amount6 => '$5.99',
        self::Price_amount7 => '$6.99',
        self::Price_amount8 => '$7.99',
        self::Price_amount9 => '$8.99',
        self::Price_amount10 => '$9.99',
        self::Price_amount11 => '$10.99',
        self::Price_amount12 => '$11.99',
        self::Price_amount13 => '$12.99',
        self::Price_amount14 => '$13.99',
        self::Price_amount15 => '$14.99',
        self::Price_amount16 => '$15.99',
        self::Price_amount17 => '$16.99',
        self::Price_amount18 => '$17.99',
        self::Price_amount19 => '$18.99',
        self::Price_amount20 => '$19.99',
        self::Price_amount21 => '$20.99',
        self::Price_amount22 => '$21.99',
        self::Price_amount23 => '$22.99',
        self::Price_amount24 => '$23.99',
        self::Price_amount25 => '$24.99',
        self::Price_amount26 => '$25.99',
        self::Price_amount27 => '$26.99',
        self::Price_amount28 => '$27.99',
        self::Price_amount29 => '$28.99',
        self::Price_amount30 => '$29.99',
        self::Price_amount31 => '$30.99',
        self::Price_amount32 => '$31.99',
        self::Price_amount33 => '$32.99',
        self::Price_amount34 => '$33.99',
        self::Price_amount35 => '$34.99',
        self::Price_amount36 => '$35.99',
        self::Price_amount37 => '$36.99',
        self::Price_amount38 => '$37.99',
        self::Price_amount39 => '$38.99',
        self::Price_amount40 => '$39.99',
        self::Price_amount41 => '$40.99',
        self::Price_amount42 => '$41.99',
        self::Price_amount43 => '$42.99',
        self::Price_amount44 => '$43.99',
        self::Price_amount45 => '$44.99',
        self::Price_amount46 => '$45.99',
        self::Price_amount47 => '$46.99',
        self::Price_amount48 => '$47.99',
        self::Price_amount49 => '$48.99',
        self::Price_amount50 => '$49.99',
        self::Price_amount51 => '$50.99',
        self::Price_amount52 => '$51.99',
        self::Price_amount53 => '$52.99',
        self::Price_amount54 => '$53.99',
        self::Price_amount55 => '$54.99',
        self::Price_amount56 => '$55.99',
        self::Price_amount57 => '$56.99',
        self::Price_amount58 => '$57.99',
        self::Price_amount59 => '$58.99',
        self::Price_amount60 => '$59.99',
        self::Price_amount61 => '$60.99',
        self::Price_amount62 => '$61.99',
        self::Price_amount63 => '$62.99',
        self::Price_amount64 => '$63.99',
        self::Price_amount65 => '$64.99',
        self::Price_amount66 => '$65.99',
        self::Price_amount67 => '$66.99',
        self::Price_amount68 => '$67.99',
        self::Price_amount69 => '$68.99',
        self::Price_amount70 => '$69.99',
        self::Price_amount71 => '$70.99',
        self::Price_amount72 => '$71.99',
        self::Price_amount73 => '$72.99',
        self::Price_amount74 => '$73.99',
        self::Price_amount75 => '$74.99',
        self::Price_amount76 => '$75.99',
        self::Price_amount77 => '$76.99',
        self::Price_amount78 => '$77.99',
        self::Price_amount79 => '$78.99',
        self::Price_amount80 => '$79.99',
        self::Price_amount81 => '$80.99',
        self::Price_amount82 => '$81.99',
        self::Price_amount83 => '$82.99',
        self::Price_amount84 => '$83.99',
        self::Price_amount85 => '$84.99',
        self::Price_amount86 => '$85.99',
        self::Price_amount87 => '$86.99',
        self::Price_amount88 => '$87.99',
        self::Price_amount89 => '$88.99',
        self::Price_amount90 => '$89.99',
        self::Price_amount91 => '$90.99',
        self::Price_amount92 => '$91.99',
        self::Price_amount93 => '$92.99',
        self::Price_amount94 => '$93.99',
        self::Price_amount95 => '$94.99',
        self::Price_amount96 => '$95.99',
        self::Price_amount97 => '$96.99',
        self::Price_amount98 => '$97.99',
        self::Price_amount99 => '$98.99',
        self::Price_amount100 => '$99.99',
    ];

    public function getRelatedApp($params = []){
        // get related app from same categories
        $category = \App\Category::find($this->category);
        if(!$category) return [];
        $length = isset($params['length']) ? (int) $params['length'] : 20;
        $start = isset($params['start']) ? (int) $params['start'] : 0;
        $apps = NewApp::where('category', $category->id)
        ->where('status', 'active')
        ->where('app_status', NewApp::STATUS_approved)
        ->skip($start)
        ->take($length)
        ->get();

        return $apps;
    }

    public function updateAverageRating(){
        $totalComment = (int) \App\AppComment::where('app_id', $this->id)
        ->count();

        $averageRating = (int) \App\AppComment::where('app_id', $this->id)
        ->avg('rating');

        $this->update([
            'total_comment' => $totalComment,
            'average_rating' => $averageRating
        ]);
    }

    public function addComment(\App\AppUser $user = null, $params =[]){
        if(!$user){
            $user = auth()->user();
        }

        // each user only comment one
        // check if user ready comment on this app then return that comment
        $comment = \App\AppComment::where('app_id', $this->id)
        ->where('user_id', $user->id)
        ->first();

        if($comment) {
            // update comment
            $comment->update([
                'comment' => isset($params['comment']) ? $params['comment'] : '',
                'rating' => isset($params['rating']) ? $params['rating'] : '',
            ]);
            $this->updateAverageRating();
            $comment->setAttribute('is_update', true);
            return $comment;
        }

        $comment = \App\AppComment::create([
            'app_id' => $this->id,
            'user_id' => $user->id,
            'comment' => isset($params['comment']) ? $params['comment'] : '',
            'rating' => isset($params['rating']) ? $params['rating'] : '',
        ]);

        $this->updateAverageRating();

        return $comment;
    }

    public function getComments($params = []){
        $length = isset($params['length']) ? (int) $params['length'] : 50;
        $start = isset($params['start']) ? (int) $params['start'] : 0;

        $comments = \App\AppComment::with(['user'])->where('app_id', $this->id)
        ->skip($start)
        ->take($length)
        ->orderBy('id', 'DESC')
        ->get();

        return $comments;
    }

    public function getCommentOfUser(\App\AppUser $user = null){
        if(!$user){
            $user = auth()->user();
        }

        $comment = \App\AppComment::with(['user'])->where('app_id', $this->id)
        ->where('user_id', $user->id)
        ->first();

        if($comment) {
            return $comment;
        }

        return null;

    }

    public function isPaid(){
        return ($this->price == NewApp::Price_Free ? false : true);
    }

    public function getPrice(){
        // remove $ character
        $price = str_replace('$', '', $this->amount);
        return floatval($price);
    }

    public function download(\App\AppUser $user = null, $sTime = null){
        if(!$user){
            $user = auth()->user();
        }
        $data = [
            'app_id' => $this->id,
            'user_id' => 11,
            'price' => $this->price == NewApp::Price_Free ? 0 : $this->getPrice()
        ];

        // if app is paid then caculator admin and developer amount
        if($this->isPaid()){
            $commissionRate = \App\Setting::getSetting('developer_commission_rate');
            $totalAmount = $this->getPrice();
            $developerAmount = $totalAmount * $commissionRate / 100;
            $adminAmount = $totalAmount - $developerAmount;
            $data['developer_amount'] = $developerAmount;
            $data['admin_amount'] = $adminAmount;
            $data['commision_rate'] = $commissionRate;
        }

        if($sTime){
            $data['created_at'] = $sTime;
            $data['updated_at'] = $sTime;
        }
        $download = \App\AppDownload::create($data);

        $this->increment('total_download');

        return $download;
    }

    public static function getTopRatedApps($params = []){
        $length = isset($params['length']) ? (int) $params['length'] : 20;
        $start = isset($params['start']) ? (int) $params['start'] : 0;

        $apps = NewApp::where('app_status', NewApp::STATUS_approved)
        ->where('status' , 'active')
        ->orderBy('average_rating', 'DESC')
        ->skip($start)
        ->take($length)
        ->get();

        return $apps;
    }

    public static function getNewApps($params = []){
        $length = isset($params['length']) ? (int) $params['length'] : 20;
        $start = isset($params['start']) ? (int) $params['start'] : 0;

        $apps = NewApp::orderBy('id', 'DESC')
        ->where('app_status', NewApp::STATUS_approved)
        ->where('status' , 'active')
        ->orderBy('id', 'DESC')
        ->skip($start)
        ->take($length)
        ->get();

        return $apps;
    }

    public function getScreenshorts(){
        $screenshorts = \App\Screenshot::where('app_id', $this->id)
        ->get();

        return $screenshorts;
    }

    public function getTitle(){
        return $this->app_name;
    }

    public function getAdminHref(){
        return route('admin.apps.detail', ['id' => $this->userid, 'appid' => $this->id]);
    }

    public function getUserHref(){
        return route('admin.apps.detail', ['id' => $this->userid, 'appid' => $this->id]);
    }

    public function createSubVersion($status = 'pending'){
        $data = $this->toArray();
        $data['is_update'] = 1;
        $data['parent_id'] = $this->id;
        $data['update_status'] = 'draft';
        $data['app_status'] = $status;
        
        $newVersion = NewApp::create($data);

        // clone screenshot
        $screenshorts = \App\Screenshot::where('app_id', $this->id)
        ->get();

        foreach($screenshorts as $img){
            $tmp = $img->toArray();
            $tmp['app_id'] = $newVersion->id;
            $cloneImg = \App\Screenshot::create($tmp);
        }

        return $newVersion;
    }

    public function isSubVersion(){
        return $this->is_update ? true : false;
    }

    public function getParentApp(){
        if(!empty($this->parent_id)){
            return NewApp::find($this->parent_id);
        }
        return null;
    }

    public function getUpdatingVersion(){
        $app = NewApp::where('parent_id', $this->id)
        ->where('is_update', 1)
        ->first();

        return $app;
    }

    public function releaseNewVersion($newVersion){
        // step 1: create sub version with current parent app
        $data = $this->toArray();
        $data['is_update'] = 0;
        $data['parent_id'] = $this->id;
        $data['update_status'] = 'success';
        $data['app_status'] = 'old_version';
        
        $oldVersion = NewApp::create($data);

        // clone screenshot to old version
        $screenshorts = \App\Screenshot::where('app_id', $this->id)
        ->get();

        foreach($screenshorts as $img){
            $tmp = $img->toArray();
            $tmp['app_id'] = $oldVersion->id;
            $cloneImg = \App\Screenshot::create($tmp);
        }

        // step 2: update current app with current release version
        $updateData = $newVersion->toArray();
        $updateData['app_status'] = 'approved';
        $updateData['is_update'] = 0;
        $updateData['parent_id'] = 0;

        // update screenshort
        // remove all screenshort of current app
        \App\Screenshot::where('app_id', $this->id)->delete();
        // get all screenshort of current version
        $screenshortsNew = \App\Screenshot::where('app_id', $newVersion->id)
        ->get();

        foreach($screenshortsNew as $img){
            $tmp = $img->toArray();
            $tmp['app_id'] = $this->id;
            $cloneImg = \App\Screenshot::create($tmp);
        }

        // remove current version update
        $newVersion->delete();
        $this->update($updateData);
    }
}
