<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Table Name
    |--------------------------------------------------------------------------
    |
    | Table name in database
    */

    "tables" => [
        'sms' => 'sms',
        'sms_gateway' => 'sms_gateways'
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespace sms drivers
    |--------------------------------------------------------------------------
    |
    | Namespace sms drivers in packages/laravel-sms/src/Drivers
    |
    */

    'namespaces' => [
        'JobMetric\Sms\Drivers',
        'App\Drivers\Sms'
    ],

];
