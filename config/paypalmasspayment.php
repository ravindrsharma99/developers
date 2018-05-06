<?php

return [
    

    /*
     * This is Authentication type, You can set it to 'api_certificate' or 'api_signature'
     */
    'authentication'    => 'api_signature',


    /*
     * You can set it to 'sandbox' or 'live'
     */
    'environment'       => 'live',


    /*
     * You can set it to 'nvp' or 'soap'
     */
    'operation_type'    => 'nvp',


    /*
     * You can set it to any valid version
     */
    'api_vesion'        => '51.0',


    /*
     * You can set it to 'email' or 'phone' or 'id'
     */
    'receiver_type'     => 'email',


    /*
     * You can set currency here
     */
    'currency'          => 'USD',
    /*
     * or other currency ('USD', 'BRL', 'GBP', 'EUR', 'JPY', 'CAD', 'AUD')
     * https://developer.paypal.com/docs/classic/api/currency_codes/ 
     */


    /*
     * These are sandbox credentials
     * You can set API Username and API Password here
     * If you set authentication as 'api_signature' then you must enter 'api_signature' here
     */
    'sandbox' => [

		        'api_username'    => 'nick_api1.thirdeyegen.com',

		        'api_password'    => 'F4EHQ85AT6SY4L9T',

                /*
                * If you set authentication as 'api_certificate' then you must enter 'api_certificate' here
                * If it is 'api_certificate' you must give proper path to cert_key_pem.txt file
                */
		        'api_certificate' => '',

                /*
                 * If you set authentication as 'api_signature' then you must enter 'api_signature' here
                 */         
		        'api_signature'   => 'AH5KWvT4dFohK1fAIzgYkdnvlFH2AnSpxkKNueeFAW3cD37Ozb5dSrSp',
	   ],

    /*
     * These are live credentials
     * You can set API Username and API Password here

     * If you set authentication as 'api_certificate' then you must enter 'api_certificate' here
     * If it is 'api_certificate' you must give proper path to cert_key_pem.txt file

     * If you set authentication as 'api_signature' then you must enter 'api_signature' here
     */
    'live' => [

		       'api_username'    => 'nick_api1.thirdeyegen.com',

		       'api_password'    => '9TE7Y8V3UR5GKH4K',

               /*
                * If you set authentication as 'api_certificate' then you must enter 'api_certificate' here
                * If it is 'api_certificate' you must give proper path to cert_key_pem.txt file
                */
		       'api_certificate' => '',

               /*
                * If you set authentication as 'api_signature' then you must enter 'api_signature' here
                */         
		       'api_signature'   => 'A9BiAtHlNpvdHOX3mPrOVBHDOETPAs9SKYgTtNz3Bj1knz0LofQDbO4U',
		],
    

    ];
