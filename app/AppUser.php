<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

use App\NewApp;
use Carbon\Carbon;

class AppUser extends Model
{
    // use SoftDeletes;
    protected $fillable = [
        'firstname','lastname','email', 'password','address','phone','status','image', 'fullname', 'google_id', 'facebook_id', 'cover'
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = encrypt($password);
    }

    public function getTitle(){
        if(!empty($this->fullname)) return $this->fullname;
        return$this->firstname . ' ' . $this->lastname;
    }

    public function viewApp(\App\NewApp $app){
        $viewer = \App\AppViewer::create([
            'app_id' => $app->id,
            'user_id' => $this->id
        ]);

        $app->increment('total_view');

        return $viewer;
    }

    public function getRecentApps($params = []){
        $length = isset($params['length']) ? (int) $params['length'] : 50;
        $start = isset($params['start']) ? (int) $params['start'] : 0;

        $views = \App\AppViewer::with(['app'])
        ->where('user_id', $this->id)
        ->skip($start)
        ->take($length)
        ->orderBy('id', 'DESC')
        ->get();

        $apps = [];
        $indexs = [];
        foreach($views as $v){
            if($v->app && $v->app->status == \App\NewApp::STATUS_ACTIVE && $v->app->app_status == \App\NewApp::STATUS_approved && !isset($indexs[$v->app->id])){
                $apps[] = $v->app;
                $indexs[$v->app->id] = true;
            }
        }
        return $apps;
    }

    public function getCard(){
        $btPaymentMethod = \App\BtPaymentMethod::where('user_id', $this->id)
        ->first();

        return $btPaymentMethod;
    }

    public function getAdminHref(){
        return route('appusers.show', ['appusers' => $this]);
    }

    // todo: testing download random app
    public function testingDownloadRandomApp($bRandomTime = true){
        // step 1: find random app to download, only active and approval are accepted
        $user = $this;
        $app = NewApp::where('status', 'active')
        ->where('app_status', \App\NewApp::STATUS_approved)
        ->inRandomOrder()->first();

        $sCreatedAt = null;
        if($bRandomTime){
            // create a random created_at in 1 month
            $createAt = Carbon::now();
            $randDate = rand(1,30);
            $createAt->addDays(- 1 * $randDate);
            $sCreatedAt = $createAt->toDateTimeString();
        }

        // step 2: handle download app
        if(!$app->isPaid()){
            // handle download free app
            $app->download($this, $sCreatedAt);
        }
        else{
            $app->download($this, $sCreatedAt);
            $commissionRate = \App\Setting::getSetting('developer_commission_rate');
            $totalAmount = $app->getPrice();
            $developerAmount = $totalAmount * $commissionRate / 100;
            $adminAmount = $totalAmount - $developerAmount;

            // create a payment record
            // make this payment is succcess
            $paymentData = [
                'app_id' => $app->id,
                'payment_type' => Payment::PAYMENT_TYPES['BUY_APP'],
                'status' => Payment::PENDING,
                'user_id' => $user->id,
                'owner_id' => $app->userid,
                'amount' => $totalAmount,
                'developer_amount' => $developerAmount,
                'admin_amount' => $adminAmount,
                'order_code' => str_random(16),
                'transaction_id' => str_random(16),
                'status' => Payment::SUCCESS,
            ];
            if($sCreatedAt){
                $paymentData['created_at'] = $sCreatedAt;
                $paymentData['updated_at'] = $sCreatedAt;
            }
            $payment = Payment::create($paymentData);

            // increase balance for developer and increase balance for admin
            $app->developer->increment('balance', $developerAmount);
            \App\Setting::increaseEarnStatistic([
                'total_amount' => $totalAmount,
                'admin_amount' => $adminAmount,
                'developer_amount' => $developerAmount
            ]);
        }
    }

    // testing: create random payment method for this user
    public function testingRandomCard(){

    }

    public function getImage(){
        if(!empty($this->image)){
            return asset($this->image);
        }
        return '';
        // return url('assets/website/images/blog/admin1.jpg');
    }
}
