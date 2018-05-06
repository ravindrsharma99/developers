<?php

namespace App\Http\Controllers\admin;

use App\Payment;
use App\Http\Controllers\Controller;
use App\Point_History;
use Illuminate\Http\Request;
use App\AppDownload;
use DB;
use Carbon\Carbon;


class ReportController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data= [];
        $data['mainmenu'] = "reports";
        $data['menu']="reports";

        $startDate = null;
        $endDate = null;

        $dateConditions = '';
        $conditions = [];
        $params = [];

        $filterType = $request->query('filter_type', 'this_week');
        if($filterType == 'range'){
            if($request->query('start_date') && $request->query('end_date')){
                $startDate = Carbon::parse($request->query('start_date'));
                $endDate = Carbon::parse($request->query('end_date'));
            }
            else{
                $filterType = 'this_week';
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
        SELECT new_apps.id, new_apps.userid, new_apps.app_name, new_apps.apk_icon, new_apps.category, count(*) as total_download
        FROM app_downloads
        JOIN new_apps ON app_downloads.app_id = new_apps.id 
        {$dateConditions}
        GROUP BY new_apps.id, new_apps.userid, new_apps.category, new_apps.app_name, new_apps.apk_icon
        ORDER BY total_download DESC 
        ";

        $items = DB::select($sql);

        $data['reports'] = $items;

        // summary 
        $summarySql = "
        SELECT count(*) as total_download FROM `app_downloads` 
        {$dateConditions}
        ";

        $summarys = DB::select($summarySql);
        $data['summary'] = $summarys[0];

        return view('admin.reports.index', $data);
    }

    public function show(Payment $payment)
    {

    }

}