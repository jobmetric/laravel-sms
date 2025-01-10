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
            "created" => "The SMS gateway was successfully created.",
            "updated" => "The SMS gateway was successfully updated.",
            "deleted" => "The SMS gateway was successfully deleted.",
        ],
    ],

    "exceptions" => [
        "sms_gateway_not_found" => "The SMS gateway with number :number was not found.",
    ],

    "list" => [
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
        "fields" => [
            "name" => [
                "title" => "Name",
            ],
            "driver" => [
                "title" => "Driver",
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
