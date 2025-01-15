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
        "sms" => [
            "send_sms_success" => "پیامک با موفقیت ارسال شد.",
        ],
        "sms_gateway" => [
            "created" => "درگاه پیامک با موفقیت ایجاد شد.",
            "updated" => "درگاه پیامک با موفقیت ویرایش شد.",
            "deleted_items" => "{1} یک مورد درگاه پیامک با موفقیت حذف شد.|[2,*] :count مورد درگاه پیامک با موفقیت حذف شدند.",
        ],
    ],

    "exceptions" => [
        "sms_gateway_not_found" => "درگاه پیامک با شماره :number یافت نشد.",
        "sms_gateway_default_not_found" => "درگاه پیامک پیش فرض یافت نشد.",
    ],

    "sms_status" => [
        "dns" => "در انتظار ارسال",
        "sent" => "ارسال شده",
        "sending" => "در حال ارسال",
        "error" => "ناموفق",
        "deliver" => "تحویل شده",
        "unknown" => "نامشخص",
    ],

    "list" => [
        "sms" => [
            "title" => "پیامک ها",
            "description" => "لیست پیامک های ارسال شده به کاربران و مشتریان.",
            "filters" => [
                "note" => [
                    "title" => "متن پیام",
                    "placeholder" => "جستجو بر اساس متن پیام",
                ],
            ],
            "columns" => [
                "note" => "متن پیام",
                "mobile" => "شماره موبایل",
                "created_at" => "تاریخ ارسال",
                "sms_gateway" => "درگاه پیامک",
                "sender" => "ارسال کننده",
                "pattern" => "الگو",
                "note_type" => "نوع پیام",
                "page" => "تعداد صفحات",
                "price" => "هزینه",
                "reference_id" => "شناسه مرجع",
                "reference_status" => "وضعیت مرجع",
            ],
            "add_modal" => [
                "title" => "ارسال پیامک",
                "fields" => [
                    "mobile_prefix" => [
                        "title" => "پیش شماره",
                    ],
                    "mobile" => [
                        "title" => "شماره موبایل",
                        "placeholder" => "شماره موبایل را وارد کنید",
                    ],
                    "note" => [
                        "title" => "متن پیام",
                        "placeholder" => "متن پیام را وارد کنید",
                    ],
                ],
            ],
        ],
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
