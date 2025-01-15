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
            "send_sms_success" => "The SMS was successfully sent.",
        ],
        "sms_gateway" => [
            "created" => "The SMS gateway was successfully created.",
            "updated" => "The SMS gateway was successfully updated.",
            "deleted_items" => "{1} One SMS gateway was successfully deleted.|[2,*] :count SMS gateways were successfully deleted.",
        ],
    ],

    "exceptions" => [
        "sms_gateway_not_found" => "The SMS gateway with number :number was not found.",
        "sms_gateway_default_not_found" => "The default SMS gateway was not found.",
    ],

    "sms_status" => [
        "dns" => "Do Not Send",
        "sent" => "Sent",
        "sending" => "Sending",
        "error" => "Error",
        "deliver" => "Delivered",
        "unknown" => "Unknown",
    ],

    "list" => [
        "sms" => [
            "title" => "SMS",
            "description" => "List of SMS sent to users and customers.",
            "filters" => [
                "note" => [
                    "title" => "Note",
                    "placeholder" => "Search by note",
                ],
            ],
            "columns" => [
                "note" => "Note",
                "mobile" => "Mobile",
                "created_at" => "Sent Date",
                "sms_gateway" => "SMS Gateway",
                "sender" => "Sender",
                "pattern" => "Pattern",
                "note_type" => "Note Type",
                "page" => "Page Count",
                "price" => "Price",
                "reference_id" => "Reference ID",
                "reference_status" => "Reference Status",
            ],
            "add_modal" => [
                "title" => "Send SMS",
                "fields" => [
                    "mobile_prefix" => [
                        "title" => "Mobile Prefix",
                    ],
                    "mobile" => [
                        "title" => "Mobile Number",
                        "placeholder" => "Enter mobile number",
                    ],
                    "note" => [
                        "title" => "Note",
                        "placeholder" => "Enter note",
                    ],
                ],
            ],
        ],
        "sms_gateway" => [
            "title" => "SMS Gateway",
            "description" => "List of SMS gateways used on the website, always one gateway must be selected as default to send SMS through it.",
            "filters" => [
                "name" => [
                    "title" => "Name",
                    "placeholder" => "Search by name",
                ],
            ],
        ],
    ],

    "form" => [
        "sms_gateway" => [
            "create" => [
                "title" => "Create SMS Gateway",
            ],
            "edit" => [
                "title" => "Edit SMS Gateway",
            ],
            "cards" => [
                "driver_fields" => "Driver Fields",
            ],
            "fields" => [
                "name" => [
                    "title" => "Name",
                    "placeholder" => "SMS Gateway Name",
                ],
                "driver" => [
                    "title" => "Driver",
                ],
            ],
        ],
    ],

    "drivers" => [
        "kavenegar" => [
            "name" => "Kavenegar",
            "fields" => [
                "api_key" => "API Key",
                "sender" => "Sender",
            ],
        ],
    ],

];
