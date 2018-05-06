<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Braintree_PaymentMethod;
use Braintree_Exception_NotFound;

class BtPaymentMethod extends Model
{
    protected $fillable = [
        'user_id', 
        'customer_id',
        'bt_customer_id',
        'last_card_number',
        // use this to get BrainTree Payment Method then create transaction later
        'payment_method_token',
        'name',
        'country_code',
        'postal_code',
        'phone',
    ];

    public function verify(){
        $paymentMethodToken = $this->payment_method_token;
        try{
            // call to brain tree and update card
            $paymentMethod = Braintree_PaymentMethod::find($this->payment_method_token);
            return [
                'status' => true,
                'payment_method' => $paymentMethod
            ];
        }
        catch(Braintree_Exception_NotFound $e){
            return [
                'status' => false,
                'error' => 'Payment method with token ' . $paymentMethodToken . ' not found'
            ];
        }
        catch(Exception $e) {
            return [
                'status' => false,
                'error' => $e->__toString()
            ];
        }
    }

}