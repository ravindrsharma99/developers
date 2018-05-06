<?php

return [
    # Define your application mode here
    'mode' => 'sandbox',

    # Account credentials from developer portal
    'account' => [
        'client_id' => env('AcpkkArtD9QuYIktsZzB6gtBwikYEn2U4qgt55JE9SbqJ6DCwKz1RDY9NgKwmK0cNjqX8nKucJ_spo9i', 'AcpkkArtD9QuYIktsZzB6gtBwikYEn2U4qgt55JE9SbqJ6DCwKz1RDY9NgKwmK0cNjqX8nKucJ_spo9i'),
        'client_secret' => env('EIYRDLvxqy_hwhkUxktbPTAud4fR4jElzXS8_VAgN-g8vkzjHPntvHhUdqJXgfne8Su9qEvnyfE8pecx', 'EIYRDLvxqy_hwhkUxktbPTAud4fR4jElzXS8_VAgN-g8vkzjHPntvHhUdqJXgfne8Su9qEvnyfE8pecx'),
    ],

    # Connection Information
    'http' => [
        'connection_time_out' => 30,
        'retry' => 1,
    ],

    # Logging Information
    'log' => [
        'log_enabled' => true,

        # When using a relative path, the log file is created
        # relative to the .php file that is the entry point
        # for this request. You can also provide an absolute
        # path here
        'file_name' => '../PayPal.log',

        # Logging level can be one of FINE, INFO, WARN or ERROR
        # Logging is most verbose in the 'FINE' level and
        # decreases as you proceed towards ERROR
        'log_level' => 'FINE',
    ],
];
