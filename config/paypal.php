<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'mode'    => 'sandbox', // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'sandbox' => [
        'username'    => env('nick_api1.thirdeyegen.com', 'nick_api1.thirdeyegen.com'),
        'password'    => env('F4EHQ85AT6SY4L9T', 'F4EHQ85AT6SY4L9T'),
        'secret'      => env('AH5KWvT4dFohK1fAIzgYkdnvlFH2AnSpxkKNueeFAW3cD37Ozb5dSrSp', 'AH5KWvT4dFohK1fAIzgYkdnvlFH2AnSpxkKNueeFAW3cD37Ozb5dSrSp'),
        'certificate' => env('', ''),
        'app_id'      => 'APP-80W284485P519543T', // Used for testing Adaptive Payments API in sandbox mode
    ],
    'live' => [
        'username'    => env('PAYPAL_LIVE_API_USERNAME', ''),
        'password'    => env('PAYPAL_LIVE_API_PASSWORD', ''),
        'secret'      => env('PAYPAL_LIVE_API_SECRET', ''),
        'certificate' => env('PAYPAL_LIVE_API_CERTIFICATE', ''),
        'app_id'      => '', // Used for Adaptive Payments API
    ],

    'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
    'currency'       => 'USD',
    'notify_url'     => '', // Change this accordingly for your application.
    'locale'         => '', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
    'validate_ssl'   => false, // Validate SSL when creating api client.
];
