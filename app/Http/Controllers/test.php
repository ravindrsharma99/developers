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



use Paypalpayment;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;
use PaypalMassPayment;


// $provider = new ExpressCheckout;      // To use express checkout.
// $provider = new AdaptivePayments;     // To use adaptive payments.

// Through facade. No need to import namespaces
// $provider = PayPal::setProvider('express_checkout');      // To use express checkout(used by default).
// $provider = PayPal::setProvider('adaptive_payments');     // To use adaptive payments.



if(!function_exists('j')){
    function j($data)
    {
        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }
}

class test extends BaseController
{
    protected $braintreeConfigure;
    public function __construct(){
        // config(['auth.defaults.guard' => 'dmobi']);

        // $this->braintreeConfigure = \App\Setting::getBraintreeConfig();

        // Braintree_Configuration::environment($this->braintreeConfigure['mode']);
        // Braintree_Configuration::merchantId($this->braintreeConfigure['marchant_id']);
        // Braintree_Configuration::publicKey($this->braintreeConfigure['public_key']);
        // Braintree_Configuration::privateKey($this->braintreeConfigure['private_key']);
    }

     public function cardpayment()
    {
        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $shippingAddress = Paypalpayment::shippingAddress();
        $shippingAddress->setLine1("3909 Witmer Road")
            ->setLine2("Niagara Falls")
            ->setCity("Niagara Falls")
            ->setState("NY")
            ->setPostalCode("14305")
            ->setCountryCode("US")
            ->setPhone("716-298-1822")
            ->setRecipientName("Jhone");

        // ### CreditCard
        $card = Paypalpayment::creditCard();
        $card->setType("visa")
            ->setNumber("4929180966646440")
            ->setExpireMonth("05")
            ->setExpireYear("2019")
            ->setCvv2("123")
            ->setFirstName("Joe")
            ->setLastName("Shopper");

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = Paypalpayment::fundingInstrument();
        $fi->setCreditCard($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments([$fi]);

        $item1 = Paypalpayment::item();
        $item1->setName('Ground Coffee 40 oz')
                ->setDescription('Ground Coffee 40 oz')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice(17.2);

      /*  $item2 = Paypalpayment::item();
        $item2->setName('Granola bars')
                ->setDescription('Granola Bars with Peanuts')
                ->setCurrency('USD')
                ->setQuantity(5)
                ->setTax(0.2)
                ->setPrice(2);*/


        $itemList = Paypalpayment::itemList();
        $itemList->setItems([$item1])
            ->setShippingAddress($shippingAddress);


        $details = Paypalpayment::details();
        $details->setSubtotal("17.2");

        //Payment Amount
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
                // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
                ->setTotal("17.2")
                ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'

        $payment = Paypalpayment::payment();

        // print_r($payment);die;

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions([$transaction]);

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create(Paypalpayment::apiContext());
        } catch (\PPConnectionException $ex) {
            return response()->json(["error" => $ex->getMessage()], 400);
        }

        return response()->json([$payment->toArray()], 200);
    }


    public function testcard2(Request $request){
        // $provider = new ExpressCheckout;      // To use express checkout.
        $provider = new AdaptivePayments;     // To use adaptive payments.
        // print_r($provider);die;

        // Through facade. No need to import namespaces
        // $provider = PayPal::setProvider('express_checkout');      // To use express checkout(used by default).
        // $provider = PayPal::setProvider('adaptive_payments');     // To use adaptive payments.

        $data = [
        'receivers'  => [
        [
        'email' => 'johndoe@example.com',
        'amount' => 10,
        'primary' => true,
        ],
        [
        'email' => 'janedoe@example.com',
        'amount' => 5,
        'primary' => false
        ]
        ],
        'payer' => 'EACHRECEIVER', // (Optional) Describes who pays PayPal fees. Allowed values are: 'SENDER', 'PRIMARYRECEIVER', 'EACHRECEIVER' (Default), 'SECONDARYONLY'
        'return_url' => url('payment/success'), 
        'cancel_url' => url('payment/cancel'),
        ];

        $response = $provider->createPayRequest($data);


        print_r($response);die;
    }

    public function testcard(Request $request){


      
        $receivers = array(
          0 => array(
            'ReceiverEmail' => "viju25042612@gmail.com", 
            'Amount'        => "10",
            'UniqueId'      => uniqid(), 
            'Note'          => " Test Streammer 1")
        );
        

//print_r( $receivers);die;

$response = PaypalMassPayment::executeMassPay('Some Subject', $receivers);
print_r($response);die;
    }
}