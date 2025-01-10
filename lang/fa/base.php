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
            "deleted_items" => "{1} یک مورد درگاه پیامک با موفقیت حذف شد.|[2,*] :count مورد درگاه پیامک با موفقیت حذف شدند.",
        ],
    ],

    "exceptions" => [
        "sms_gateway_not_found" => "درگاه پیامک با شماره :number یافت نشد.",
    ],

    "list" => [
        "sms_gateway" => [
            "title" => "درگاه پیامک",
            "description" => "لیست درگاه های پیامک که در وبسایت استفاده می‌شوند، همیشه باید یک درگاه به صورت پیش فرض انتخاب شده باشد که پیامک ها از طریق آن ارسال شوند.",
            "filters" => [
                "name" => [
                    "title" => "نام",
                    "placeholder" => "جستجو بر اساس نام",
                ],
            ],
        ],
    ],

    "form" => [
        "sms_gateway" => [
            "create" => [
                "title" => "ایجاد درگاه پیامک",
            ],
            "edit" => [
                "title" => "ویرایش درگاه پیامک",
            ],
            "cards" => [
                "driver_fields" => "فیلدهای درایور",
            ],
            "fields" => [
                "name" => [
                    "title" => "نام",
                    "placeholder" => "نام درگاه پیامک",
                ],
                "driver" => [
                    "title" => "درایور",
                ],
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
