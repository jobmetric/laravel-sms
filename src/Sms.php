<?php

namespace JobMetric\Sms;

use Illuminate\Support\Str;
use JobMetric\Sms\Enums\SmsFieldNoteTypeEnum;

class Sms
{
    /**
     * Process sms text
     *
     * @param string $text
     *
     * @return array
     */
    public static function processText(string $text): array
    {
        $textLength = Str::length($text);
        $regexPersian = '/[آابپتسجچهابپتثجچحخدذرزژسشصضطظعغفقکگلمینوهءآاًهٔة۰۱۲۳۴۵۶۷۸۹]/';

        $isPersian = preg_match($regexPersian, $text);
        $type = $isPersian ? SmsFieldNoteTypeEnum::FARSI() : SmsFieldNoteTypeEnum::LATIN();

        $limits = $isPersian
            ? [70, 134, 201, 67]
            : [160, 306, 459, 153];

        if ($textLength <= $limits[0]) {
            $page = 1;
        } elseif ($textLength <= $limits[1]) {
            $page = 2;
        } elseif ($textLength <= $limits[2]) {
            $page = 3;
        } else {
            $page = round(($textLength - $limits[2]) / $limits[3]) + 4;
        }

        return [
            'type' => $type,
            'page' => $page,
        ];
    }
}
