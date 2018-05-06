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
use App\BtCustomer;
use App\BtPaymentMethod;
use App\Payment;

// import BrainTree Library
use Braintree_Configuration;
use Braintree_PaymentMethod;
use Braintree_Customer;
use Braintree_ClientToken;
use Braintree_Exception_NotFound;
use Braintree_Transaction;


use Srmklive\PayPal\Services\AdaptivePayments;



if(!function_exists('j')){
    function j($data)
    {
        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }
}

class PaymentController extends BaseController
{
    protected $braintreeConfigure;
    public function __construct(){
        config(['auth.defaults.guard' => 'dmobi']);

        $this->braintreeConfigure = \App\Setting::getBraintreeConfig();

        Braintree_Configuration::environment($this->braintreeConfigure['mode']);
        Braintree_Configuration::merchantId($this->braintreeConfigure['marchant_id']);
        Braintree_Configuration::publicKey($this->braintreeConfigure['public_key']);
        Braintree_Configuration::privateKey($this->braintreeConfigure['private_key']);
    }

    public function generateClientToken(Request $request){
        $clientToken = Braintree_ClientToken::generate();
        if(empty($clientToken)){
            return [
                'status' => false,
                'message' => trans('message.cannot_generate_client_token_now')
            ];
        }
	    return [
			'status' => true,
			'client_token' => $clientToken
        ];
    }

    public function saveCard(Request $request){
        $validator = Validator::make($request->all(), [
            'nonce' => 'required',
            'last_card_number' => 'required'
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return [
                'status' => false,
                'message' => $errors[0],
                'errors' => $errors,
            ];
        }

        $user = auth()->user();

        $tokenNonce = $request->input('nonce');
        $bCreate = true;
        $btCustomer = BtCustomer::where('user_id' , $user->id)->first();
        if($btCustomer){
            $bCreate = false;
        }

        $customerId = null;
        $customer = null;

        if(!$btCustomer){
            // first create a customer
            $result = Braintree_Customer::create([
                'firstName' => $user->firstname,
                'lastName' => $user->lastname,
                'email' => $user->email,
                'phone' => $user->phone,
            ]);

            if(empty($result)){
                return [
                    'status' => false,
                    'message' => trans('message.something_was_wrong')
                ];
            }
            if(!$result->success){
                $message = trans('message.something_was_wrong');
                if(isset($result->message) && !empty($result->message)){
                    $message = $result->message;
                }
                return [
                    'status' => false,
                    'message' => $message,
                    'error_code' => 'CREATE_CUSTOMER'
                ];
            }
            
            $customer = $result->customer;
            $customerId = $result->customer->id;
            
            $btCustomer = BtCustomer::create([
                'user_id' => $user->id,
                'customer_id' => $customerId
            ]);
        }
        else{
            $customerId = $btCustomer->customer_id;
            // try to connect braintree to get current customer
            try{
                $customer = Braintree_Customer::find($customerId);
                // this's customer is ok
            }
            catch(Braintree_Exception_NotFound $e){
                // this customer is not found or deleted then recreate this customer
                // step 1: create brain tree customer
                $result = Braintree_Customer::create([
                    'firstName' => $user->firstname,
                    'lastName' => $user->lastname,
                    'email' => $user->email,
                    'phone' => $user->phone
                ]);
    
                if(empty($result)){
                    return [
                        'status' => false,
                        'message' => trans('message.something_was_wrong')
                    ];
                }
                if(!$result->success){
                    $message = trans('message.something_was_wrong');
                    if(isset($result->message) && !empty($result->message)){
                        $message = $result->message;
                    }
                    return [
                        'status' => false,
                        'message' => $message,
                        'error_code' => 'CREATE_CUSTOMER'
                    ];
                }
                $customer = $result->customer;
                // step 2: update customer id
                $customerId = $customer->id;
                $btCustomer->customer_id = $customerId;
                $btCustomer->save();
            }
        }
        
        $btPaymentMethod = BtPaymentMethod::where('customer_id', $btCustomer->id)->first();
        if(!$btPaymentMethod){
            $btPaymentMethod = BtPaymentMethod::create([
                'user_id' => $user->id,
                'customer_id' => $btCustomer->id,
                'bt_customer_id' => $customerId,
                'payment_method_token' => str_random(16),
                'last_card_number' => $request->input('last_card_number'),
                'name' => $request->input('name', ''),
                'country_code' => $request->input('country_code', ''),
                'postal_code' => $request->input('postal_code', ''),
                'phone' => $request->input('phone', ''),
            ]);
        }

        try{
            $lastCardNumber = $request->input('last_card_number');
            // update card if card changed
            if($lastCardNumber != $btPaymentMethod->last_card_number){
                $btPaymentMethod->last_card_number = $lastCardNumber;
                $btPaymentMethod->name = $request->input('name', '');
                $btPaymentMethod->country_code = $request->input('country_code', '');
                $btPaymentMethod->postal_code = $request->input('postal_code', '');
                $btPaymentMethod->phone = $request->input('phone', '');
                
                $btPaymentMethod->save();
            }
            // call to brain tree and update card
            $paymentMethod = Braintree_PaymentMethod::find($btPaymentMethod->payment_method_token);
            $result = Braintree_PaymentMethod::update( $paymentMethod->token, [
                    'paymentMethodNonce' => $tokenNonce,
                    'options' => [
                        'makeDefault' => true,
                        'verifyCard' => true,
                        // 'failOnDuplicatePaymentMethod' => true
                    ]
                ]
            );

            if(!$result->success){
                return [
                    'status' => false,
                    'message' => trans('message.card_is_invalid'),
                    'message_detail' => $result->message,
                    'error_code' => 'UPDATE_PAYMENT_METHOD'
                ];
            }
        }
        catch(Braintree_Exception_NotFound $e){
            // create payment method for this customer if card is not exists
            $paymentMethodRresult = Braintree_PaymentMethod::create([
                'customerId' => $customerId,
                'paymentMethodNonce' => $tokenNonce, 
                'token' => $btPaymentMethod->payment_method_token,
                'options' => [
                    'makeDefault' => true,
                    'verifyCard' => true,
                    // 'failOnDuplicatePaymentMethod' => true
                ]
            ]);

            if(!$paymentMethodRresult->success){
                return [
                    'status' => false,
                    'message' => $paymentMethodRresult->message,
                    'error_code' => 'CREATE_PAYMENT_METHOD'
                ];
            }

        }
        catch(Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }

		return [
			'status' => true,
            'message' => trans('message.save_card_success'),
            'card' => $btPaymentMethod
		];

    }

    public function getCard(){
        // $user = auth()->user();
        $btPaymentMethod = BtPaymentMethod::where('user_id' , 4)->first();
        if(!$btPaymentMethod){
            return [
                'status' => false,
                'message' => trans('message.no_found_found_add_new_one')
            ];
        }
        return [
            'status' => true,
            'card' => $btPaymentMethod
        ];
    }



    public function downloadApp(Request $request, $id){

        $app = NewApp::with(['developer'])->find($id);
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

        $user = auth()->user();

        if(!$app->isPaid()){
            $app->download();
            return [
                'status' => true
            ];
        }

        // handle payment here
        $card = $this->getCard();


        if(!$card){
            return [
                'status' => false,
                'message' => trans('message.no_card_is_avaiable'),
                'error_code' => 'CARD_NOT_FOUND'
            ];
        }
        $verifyCardResult = $card->verify();
        if(!$verifyCardResult['status']){
            return [
                'status' => false,
                'message' => $verifyCardResult['error'],
                'error_code' => "CARD_IS_INVALID'"
            ];
        }
        $paymentMethod = $verifyCardResult['payment_method'];
        // print_r($paymentMethod);die;
        $amount = $app->getPrice();
        if($amount <= 0){
            // this app free
            $app->download();
            return [
                'status' => true
            ];
        }
        $commissionRate = \App\Setting::getSetting('developer_commission_rate');


        $totalAmount = $app->getPrice();
        $developerAmount = $totalAmount * $commissionRate / 100;
        $adminAmount = $totalAmount - $developerAmount;
        // print_r($totalAmount);die;
        // print_r($commissionRate);//60
        // echo "comminons";
        // print_r($totalAmount);//3.99
        // echo "totalAmount";
        // print_r($developerAmount);//2.394
        // echo "developerAmount";
        // print_r($adminAmount);
        // echo "adminAmount";


        // die;
        // create a payment record
        $payment = Payment::create([
            'app_id' => $app->id,
            'payment_type' => Payment::PAYMENT_TYPES['BUY_APP'],
            'status' => Payment::PENDING,
            'user_id' => $user->id,
            'owner_id' => $app->userid,
            'amount' => $totalAmount,
            'developer_amount' => $developerAmount,
            'admin_amount' => $adminAmount,
            'order_code' => str_random(16),
        ]);
        // begin create transaction sale
        $result = Braintree_Transaction::sale([
            'amount' => round($developerAmount,1),
            'orderId' => "fgsdg",
              'customerId' => "895373083",
            // customerId or paymentMethodToken
            // 'paymentMethodToken' => "q4Y2z51JGcTK1Dhi",
            'options' => [
                'submitForSettlement' => True
            ]
        ]);


            $result1 = Braintree_Transaction::sale([
            'amount' => round($adminAmount,1),
            'orderId' => "fgsdg",
              'customerId' => "895373083",
            // customerId or paymentMethodToken
            // 'paymentMethodToken' => "q4Y2z51JGcTK1Dhi",
            'options' => [
                'submitForSettlement' => True
            ]
        ]);
        // echo "<pre>";
        // print_r($result);die;
            
        if ($result->success) {
            $app->download();
            // See $result->transaction for details
            $transaction = $result->transaction;
            $payment->status = Payment::SUCCESS;
            $payment->transaction_id = $transaction->id;
            $payment->data = $transaction->__toString();
            $payment->save();

            // increase balance for developer and increase balance for admin
            $app->developer->increment('balance', $developerAmount);
            $app->developer->increment('total_earned', $developerAmount);
            \App\Setting::increaseEarnStatistic([
                'total_amount' => $totalAmount,
                'admin_amount' => $adminAmount,
                'developer_amount' => $developerAmount
            ]);

            return [
                'status' => true,
                'message' => trans('message.purchased_this_app')
            ];

        } else {
            // Handle errors
            $payment->status = Payment::FAILED;
            $payment->error = $result->message;
            $payment->save();

            return [
                'status' => false,
                'message' => trans('message.payment_failed') . ' '. $result->message,
                'error_code' => 'PAYMENT_FAILED'
            ];
        }

        return [
            'status' => true
        ];
    }
}