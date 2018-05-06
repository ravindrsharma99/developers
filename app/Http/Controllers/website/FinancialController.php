<?php

namespace App\Http\Controllers\website;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\WithdrawRequest;
use Session;
use App\WebUser;
use View;
use Carbon\Carbon;
use DB;
use Mail;
use App\Mail\WithdrawEmail;

class FinancialController extends Controller
{
    protected $user;

    public function initUser(){
        $sessionUser = session()->get('SESS_USER');
        if($sessionUser){
            $this->user = WebUser::find($sessionUser->id);
            if(!$this->user){
                // stop current page return page not found
                // abort(404);
                return redirect()->route('webuser.login')->send();
            }
            View::share(['user' => $this->user]);
        }
        else{
            return redirect()->route('webuser.login')->send();
        }
    }

    public function index(Request $request)
    {
        $this->initUser();
        $data['menu']="financial";
        
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();

        $requests = WithdrawRequest::orderBy('updated_at', 'DESC')
        ->get();

        $data['withdrawRequests'] = $requests;

        return view('website.financial.index', $data);
    }

    public function reports(Request $request){
        $this->initUser();
        $data['menu']="user_reports";
        
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();

        $startDate = null;
        $endDate = null;

        $dateConditions = '';
        $conditions = [
            'new_apps.userid = ' . $this->user->id
        ];
        $params = [];

        $filterType = $request->query('filter_type', 'all_time');
        if($filterType == 'range'){
            if($request->query('start_date') && $request->query('end_date')){
                $startDate = Carbon::parse($request->query('start_date'));
                $endDate = Carbon::parse($request->query('end_date'));
            }
            else{
                $filterType = 'all_time';
            }   
        }

        if($filterType == 'this_week'){
            $beginCurrentWeek = Carbon::now();
            $beginCurrentWeek->addDays(-1 * $beginCurrentWeek->dayOfWeek);
            $beginCurrentWeek->hour = 0;
            $beginCurrentWeek->minute = 0;
            $beginCurrentWeek->second = 1;
            $startDate = $beginCurrentWeek;
        }
        else if($filterType == 'this_month'){
            $beginCurrentMonth = Carbon::now();
            $beginCurrentMonth->day = 1;
            $beginCurrentMonth->hour = 0;
            $beginCurrentMonth->minute = 0;
            $beginCurrentMonth->second = 1;
            $startDate = $beginCurrentMonth;
        }
        else if($filterType == 'today'){
            $beginOfToday = Carbon::now();
            $beginOfToday->hour = 0;
            $beginOfToday->minute = 0;
            $beginOfToday->second = 1;
            $startDate = $beginOfToday;
        }

        if($startDate){
            $conditions[] = "app_downloads.created_at >= '" . $startDate->toDateTimeString() . "'"; 
        }
        if($endDate){
            $conditions[] = "app_downloads.created_at <= '" . $endDate->toDateTimeString() . "'";
        }

        if(!empty($conditions)){
            $dateConditions = 'WHERE ' . implode(' AND ', $conditions);
        }

        $params['filter_type'] = $filterType;
        if($startDate){
            $params['start_date'] = $startDate->toDateString();
        }
        if($endDate){
            $params['end_date'] = $endDate->toDateString();
        }

        $data['params'] = $params;

        $sql = "
        SELECT new_apps.id, new_apps.userid, new_apps.app_name, new_apps.apk_icon, new_apps.category, new_apps.amount, count(*) as total_download, sum(app_downloads.developer_amount) as total_earned
        FROM app_downloads
        JOIN new_apps ON app_downloads.app_id = new_apps.id 
        {$dateConditions}
        GROUP BY new_apps.id, new_apps.userid, new_apps.category, new_apps.app_name, new_apps.apk_icon, new_apps.amount
        ORDER BY total_download DESC 
        ";

        $items = DB::select($sql);
        $data['reports'] = $items;

        $summarySql = "
        SELECT count(*) as total_download, sum(app_downloads.developer_amount) as total_earned FROM `app_downloads` 
        JOIN new_apps ON app_downloads.app_id = new_apps.id
        {$dateConditions}
        ";

        $commissionRate = \App\Setting::getSetting('developer_commission_rate');

        $summarys = DB::select($summarySql);
        $data['summary'] = $summarys[0];
        $data['commissionRate'] = $commissionRate;

        return view('website.financial.report', $data);
    }

    public function create(Request $request){
        $this->initUser();

        // check if this user has enough condition to create a withdraw request
        $minimumWithdrawalAmount = \App\Setting::getSetting('minimum_withdrawal_amount');
        if($this->user->balance < $minimumWithdrawalAmount){
            Session::flash('error', "Can not create withdraw request. Your balance must be greater or equal $" . $minimumWithdrawalAmount);
            return redirect()->route('financial.index');
        }
        
        $data['menu']="financial";
        
        $data['category_id'] = Category::where('status','active')->pluck('name','id')->all();

        
        $data['minimumWithdrawalAmount'] = $minimumWithdrawalAmount;

        return view('website.financial.create', $data);
    }

    public function store(Request $request){
        $this->initUser();
        $minimumWithdrawalAmount = \App\Setting::getSetting('minimum_withdrawal_amount');
        $maximum = floor($this->user->balance);
        $this->validate($request, [
            'paypal_email' => 'required|email',
            'amount' => "required|numeric|min:{$minimumWithdrawalAmount}|max:{$maximum}"
        ]);

        $data = $request->all();
        $data['user_id'] = $this->user->id;
        $data['status'] = WithdrawRequest::PENDING;
        $data['code'] = 'REQ-' . str_random(8);

        $withdrawRequest = WithdrawRequest::create($data);
        $amount = floatval($data['amount']);
        // update user data
        $currentUser = WebUser::find($this->user->id);
        if(empty($currentUser->paypal_email)){
            $currentUser->paypal_email = $data['paypal_email'];
        }
        $currentUser->balance-= $amount;
        $currentUser->withdrawal_pending+= $amount;
        $currentUser->save();

        Mail::to($currentUser->email)->send(new WithdrawEmail($withdrawRequest));

        session(['SESS_USER' => $currentUser]);

        Session::flash('success', 'Sent withdraw request to admin success. Please wait admin approve your request.');
        return redirect()->route('financial.index');
    }
}
