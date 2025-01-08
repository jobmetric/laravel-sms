<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base Sms Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during Sms for various
    | messages that we need to display to the user.
    |
    */

    "validation" => [
    ],

    "messages" => [
        "sms_gateway" => [
            "created" => "درگاه پیامک با موفقیت ایجاد شد.",
            "updated" => "درگاه پیامک با موفقیت ویرایش شد.",
            "deleted" => "درگاه پیامک با موفقیت حذف شد.",
        ],
    ],

    "exceptions" => [
        "sms_gateway_not_found" => "درگاه پیامک با شماره :number یافت نشد.",
    ],

    "form" => [
        "fields" => [
            "name" => [
                "title" => "نام",
            ],
            "driver" => [
                "title" => "درایور",
            ],
        ],
    ],

    "drivers" => [
        "kavenegar" => [
            "name" => "کاوه نگار",
            "fields" => [
                "api_key" => "کلید API",
                "sender" => "ارسال کننده",
            ],
        ],
    ],

];
