<?php

namespace App\Http\Controllers\admin;

use App\Payment;
use App\Http\Controllers\Controller;
use App\Point_History;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class PaymentController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data= [];
        $data['mainmenu'] = "payments";
        $data['menu']="payments";

        $startDate = null;
        $endDate = null;

        $dateConditions = '';
        $conditions = [];
        $params = [];

        $query = Payment::with(['owner', 'user', 'app']);

        $filterType = $request->query('filter_type', 'this_month');
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
            $conditions[] = "created_at >= '" . $startDate->toDateTimeString() . "'"; 
        }
        if($endDate){
            $conditions[] = "created_at <= '" . $endDate->toDateTimeString() . "'";
        }

        if(!empty($conditions)){
            $dateConditions = 'WHERE ' . implode(' AND ', $conditions);
        }

        $params['filter_type'] = $filterType;

        $summaryQuery = null;
        if($startDate){
            $params['start_date'] = $startDate->toDateString();
            $query->whereDate('created_at', '>=' , $startDate->toDateString());
            if(!$summaryQuery){
                $summaryQuery = Payment::whereDate('created_at', '>=' , $startDate->toDateString());
            }
            else{
                $summaryQuery->whereDate('created_at', '>=' , $startDate->toDateString());
            }
        }
        if($endDate){
            $params['end_date'] = $endDate->toDateString();
            $query->whereDate('created_at', '<=' , $endDate->toDateString());
            if(!$summaryQuery){
                $summaryQuery = Payment::whereDate('created_at', '<=' , $endDate->toDateString());
            }
            else{
                $summaryQuery->whereDate('created_at', '<=' , $endDate->toDateString());
            }
        }

        $data['params'] = $params;
        $items = $query
        ->orderBy('id', 'desc')
        ->get();

        $data['payments'] = $items;

        // summary 
        // $summarySql = "
        // SELECT SUM(amount) as total_amount FROM `payments` 
        // {$dateConditions}
        // ";
        // $summarys = DB::select($summarySql);
        // $data['summary'] = $summarys[0];

        $totalAmount = $summaryQuery ? $summaryQuery->sum('amount') : Payment::sum('amount');
        $data['summary'] = [
            'total_amount' => $totalAmount
        ];

        return view('admin.payments.index', $data);
    }

    public function show(Payment $payment)
    {
        $data=[];
        $data['menu']="payments";
        $data['mainmenu'] = "payments";
        $data['payment'] = $payment;
        return view('admin.payments.view', $data);
    }

    public function updateStatistic(Request $request){
        $statistic = \App\Setting::updateStatistic();

        return [
            'status' => true,
            'statistic' => $statistic
        ];
    }

}