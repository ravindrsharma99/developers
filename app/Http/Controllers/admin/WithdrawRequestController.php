<?php

namespace App\Http\Controllers\admin;

use App\WithdrawRequest;
use App\Http\Controllers\Controller;
use App\Point_History;
use Illuminate\Http\Request;
use Session;
use App\Setting;

class WithdrawRequestController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data= [];
        $data['mainmenu'] = "withdraw-requests";
        $data['menu']="withdraw-requests";
        $data['items'] = WithdrawRequest::with(['user'])->orderBy('id', 'desc')
        ->get();
        return view('admin.withdraw-requests.index', $data);
    }

    public function show(WithdrawRequest $withdrawRequest)
    {
        $data=[];
        $data['menu'] = "withdraw-requests";
        $data['mainmenu'] = "withdraw-requests";
        $data['withdrawRequest'] = $withdrawRequest;
        return view('admin.withdraw-requests.view', $data);
    }

    public function update(Request $request, WithdrawRequest $withdrawRequest){
        $this->validate($request, [
            'status' => 'required'
        ]);

        $status = $request->input('status');
        if($withdrawRequest->status != $status){
            $data = $request->all();
            if($status != WithdrawRequest::FAILED){
                if(isset($data['failure_reason'])){
                    unset($data['failure_reason']);
                }
            }
            $withdrawRequest->update($data);

            $developer = $withdrawRequest->user;
            $amount = floatval($withdrawRequest->amount);
            if($status == WithdrawRequest::SUCCESS){
                // update user money
                $developer->withdrawal_pending-= $amount;
                $developer->total_withdrawal+= $amount;
                $developer->save();
    
                // update site statistic
                Setting::increaseSetting('total_paid_for_developer', $amount);
                Setting::increaseSetting('current_balance', -1 * $amount);
            }
            else if($status == WithdrawRequest::FAILED){
                // update user money
                $developer->balance+= $amount;
                $developer->withdrawal_pending-= $amount;
                $developer->save();
            }

            $withdrawRequest->sendEmail();
    
            Session::flash('success', 'Updated request successfully.');
        }
        
        return redirect()->route('admin.withdraw-requests.index');
    }

}