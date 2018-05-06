<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Session;

class StripeController extends Controller
{
    public function stripeSetup(Request $request)
    {
        return view('website.stripe.setup');
    }

    public function stripeStandardAuthorize(){
        $url = "https://connect.stripe.com/oauth/authorize?response_type=code&client_id=ca_32D88BD1qLklliziD7gYQvctJIhWBSQ7&scope=read_write";
        
    }

    public function stripeAuthorize()
    {
        $stripeClientId = Setting::getSetting('stripe_client_id');
        $stripeCallbackUrl = route('stripe.connect');
        $state = str_random(16);
        session(['stripe_security_code' => $state]);
        $url = "https://connect.stripe.com/express/oauth/authorize?redirect_uri={$stripeCallbackUrl}&client_id={$stripeClientId}&state={$state}";
        return redirect()->to($url);
    }

    public function connect(Request $request)
    {
        // http://thirdeyegen.dmobisoft.com/connect?code={AUTHORIZATION_CODE}
        $code = $request->query('code');
        $stripeClientSecret = Setting::getSetting('stripe_client_secret');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://connect.stripe.com/oauth/token');
        $params = [
            'client_secret' => $stripeClientSecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $fieldString = http_build_query($params);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldString);

        // disable verify host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        if (!curl_errno($ch)) {
            // success
            $data = json_decode($response, true);
            if (isset($data['error'])) {
                return [
                    'status' => false,
                    'error' => $data['error'],
                    'error_description' => $data['error_description'],
                ];
            }
            // data
            // {
            //     "access_token": "{ACCESS_TOKEN}",
            //     "livemode": false,
            //     "refresh_token": "{REFRESH_TOKEN}",
            //     "token_type": "bearer",
            //     "stripe_publishable_key": "{PUBLISHABLE_KEY}",
            //     "stripe_user_id": "{ACCOUNT_ID}",
            //     "scope": "express"
            // }
            $stripeAccountId = $data['stripe_user_id'];
            // create simple charge
            // Set your secret key: remember to change this to your live secret key in production
            // See your keys here: https://dashboard.stripe.com/account/apikeys
            \Stripe\Stripe::setApiKey($stripeClientSecret);

            try {
                // node amount  cent mean $ * 100
                $amount = 10 * 100;
                $charge = \Stripe\Charge::create(array(
                    "amount" => $amount,
                    "currency" => "usd",
                    "source" => "tok_visa",
                    "destination" => array(
                        "account" => $stripeAccountId,
                    ),
                ));

                return [
                    'status' => true,
                    'data' => $data,
                    'charge' => $charge,
                ];
            } catch (\Stripe\Error\Card $e) {
                // Since it's a decline, \Stripe\Error\Card will be caught
                // $body = $e->getJsonBody();
                // $err  = $body['error'];

                // print('Status is:' . $e->getHttpStatus() . "\n");
                // print('Type is:' . $err['type'] . "\n");
                // print('Code is:' . $err['code'] . "\n");
                // // param is '' in this case
                // print('Param is:' . $err['param'] . "\n");
                // print('Message is:' . $err['message'] . "\n");
                // // echo $e->__toString();die;
                // die;
                $error = $this->handleStripeError($e);
                return [
                    'status' => false,
                    'error' => $error,
                ];
            } catch (\Stripe\Error\RateLimit $e) {
                // Too many requests made to the API too quickly
                $error = $this->handleStripeError($e);
                return [
                    'status' => false,
                    'error' => $error,
                ];
            } catch (\Stripe\Error\InvalidRequest $e) {
                // Invalid parameters were supplied to Stripe's API
                $error = $this->handleStripeError($e);
                return [
                    'status' => false,
                    'error' => $error,
                ];
            } catch (\Stripe\Error\Authentication $e) {
                // Authentication with Stripe's API failed
                // (maybe you changed API keys recently)
                $error = $this->handleStripeError($e);
                return [
                    'status' => false,
                    'error' => $error,
                ];
            } catch (\Stripe\Error\ApiConnection $e) {
                // Network communication with Stripe failed
                $error = $this->handleStripeError($e);
                return [
                    'status' => false,
                    'error' => $error,
                ];
            } catch (\Stripe\Error\Base $e) {
                // Display a very generic error to the user, and maybe send
                // yourself an email
                $error = $this->handleStripeError($e);
                return [
                    'status' => false,
                    'error' => $error,
                ];
            } catch (Exception $e) {
                // Something else happened, completely unrelated to Stripe
                $error = $this->handleStripeError($e);
                return [
                    'status' => false,
                    'error' => $error,
                ];
            }

        } else {
            $error = curl_error($ch);
            curl_close($ch);
            return [
                'status' => false,
                'error' => $error,
            ];
        }
    }

    public function handleStripeError($e)
    {
        // Since it's a decline, \Stripe\Error\Card will be caught
        $body = $e->getJsonBody();
        $err = $body['error'];

        $data = [
            'http_status' => $e->getHttpStatus(),
        ];

        // print('Status is:' . $e->getHttpStatus() . "\n");
        // print('Type is:' . $err['type'] . "\n");
        if (isset($err['code'])) {
            // print('Code is:' . $err['code'] . "\n");
            $data['code'] = $err['code'];
        }
        if (isset($err['param'])) {
            // param is '' in this case
            // print('Param is:' . $err['param'] . "\n");
            $data['params'] = $err['param'];
        }
        if (isset($err['message'])) {
            // print('Message is:' . $err['message'] . "\n");
            $data['message'] = $err['message'];
        }

        // echo $e->__toString();die;
        // die;
        return $data;
    }

    public function sale(Request $request)
    {

        return view('website.stripe.sale', [
            'stripe_public_key' => 'pk_test_cbZRS1nTE3KEcpfOQpedcoGt',
        ]);
    }

    public function charge(Request $request)
    {
        $token = $request->input('stripeToken');

        $stripeClientSecret = Setting::getSetting('stripe_client_secret');
        \Stripe\Stripe::setApiKey($stripeClientSecret);

        $stripeAccountId = 'acct_1BQ8F8L4qOF3qOgn';

        try {
            // $customer = \Stripe\Customer::create(array(
            //     'email' => 'customer@example.com',
            //     'source'  => $token
            // ));

            $charge = \Stripe\Charge::create(array(
                // 'customer' => $customer->id,
                'amount' => 5000,
                'currency' => 'usd',
                "source" => $token,
                "destination" => array(
                    "account" => $stripeAccountId,
                ),
            ));

            return [
                'status' => true,
                'charge' => $charge
            ];
        } catch (\Stripe\Error\Card $e) {
            $error = $this->handleStripeError($e);
            return [
                'status' => false,
                'error' => $error,
            ];
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $error = $this->handleStripeError($e);
            return [
                'status' => false,
                'error' => $error,
            ];
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $error = $this->handleStripeError($e);
            return [
                'status' => false,
                'error' => $error,
            ];
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $error = $this->handleStripeError($e);
            return [
                'status' => false,
                'error' => $error,
            ];
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $error = $this->handleStripeError($e);
            return [
                'status' => false,
                'error' => $error,
            ];
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $error = $this->handleStripeError($e);
            return [
                'status' => false,
                'error' => $error,
            ];
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $error = $this->handleStripeError($e);
            return [
                'status' => false,
                'error' => $error,
            ];
        }
    }
}
