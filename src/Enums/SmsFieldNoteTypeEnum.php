<?php

namespace JobMetric\Sms\Enums;

use JobMetric\PackageCore\Enums\EnumToArray;

/**
 * @method static FARSI()
 * @method static LATIN()
 */
enum SmsFieldNoteTypeEnum: string
{
    use EnumToArray;

    case FARSI = "farsi";
    case LATIN = "latin";
}
