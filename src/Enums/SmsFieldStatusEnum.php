<?php

namespace JobMetric\Sms\Enums;

use JobMetric\PackageCore\Enums\EnumToArray;

/**
 * @method static DNS()
 * @method static SENT()
 * @method static SENDING()
 * @method static ERROR()
 * @method static DELIVER()
 * @method static UNKNOWN()
 */
enum SmsFieldStatusEnum: string
{
    use EnumToArray;

    case DNS = "dns"; // Do Not Send
    case SENT = "sent";
    case SENDING = "sending";
    case ERROR = "error";
    case DELIVER = "deliver";
    case UNKNOWN = "unknown";
}
