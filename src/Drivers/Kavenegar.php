<?php

namespace JobMetric\Sms\Drivers;

use Exception;
use Illuminate\Support\Facades\Log;
use JobMetric\Sms\Contracts\SmsContract;
use JobMetric\Sms\Enums\SmsFieldStatusEnum;
use JobMetric\Sms\Models\Sms;
use JobMetric\Sms\Models\SmsGateway;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use Kavenegar\KavenegarApi;
use Throwable;

class Kavenegar implements SmsContract
{
    public string $api_key;
    public string $sender;

    /**
     * Get Driver Name
     *
     * @return string
     */
    public function getDriverName(): string
    {
        return 'sms::base.drivers.kavenegar.name';
    }

    /**
     * Get Fields
     *
     * @return array
     */
    public function getFields(): array
    {
        return [
            'api_key' => 'sms::base.drivers.kavenegar.fields.api_key',
            'sender' => 'sms::base.drivers.kavenegar.fields.sender',
        ];
    }

    /**
     * Set params
     *
     * @param SmsGateway $smsGateway
     *
     * @return void
     */
    public function setParams(SmsGateway $smsGateway): void
    {
        $this->api_key = $smsGateway->fields['api_key'] ?? null;
        $this->sender = $smsGateway->fields['sender'] ?? env('KAVENEGAR_API_SENDER');
    }

    /**
     * Send sms
     *
     * @param Sms $sms
     *
     * @return void
     * @throws Exception
     */
    public function send(Sms $sms): void
    {
        $mobile = str_replace('+', '00', $sms->mobile_prefix) . $sms->mobile;

        if (env('DO_NOT_SEND_SMS')) {
            $sms->status = SmsFieldStatusEnum::SENT();
            $sms->save();

            return;
        }

        try {
            $api = new KavenegarApi($this->api_key);
            $result = $api->Send($this->sender, $mobile, $sms->note);

            $trace = json_decode($sms->reference_trace, true);
            $trace[time()] = $result;
            if ($result) {
                $sms->reference_id = $result[0]->messageid;
                $sms->reference_status = $result[0]->status;
                $sms->reference_trace = json_encode($trace);
                $sms->price = $result[0]->cost;
                $sms->sender = $result[0]->sender;

                $sms->status = SmsFieldStatusEnum::SENDING;

                $sms->save();
            } else {
                throw new Exception('fail send message to user');
            }
        } catch (ApiException|HttpException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Send lookup
     *
     * @param Sms $sms
     * @param array $tokens
     *
     * @return void
     * @throws Throwable
     */
    public function lookup(Sms $sms, array $tokens = []): void
    {
        $mobile = str_replace('+', '00', $sms->mobile_prefix) . $sms->mobile;

        if (env('DO_NOT_SEND_SMS')) {
            $sms->status = SmsFieldStatusEnum::SENT;
            $sms->save();

            return;
        }

        try {
            $api = new KavenegarApi($this->api_key);

            $result = $api->VerifyLookup($mobile, $tokens[0], $tokens[1], $tokens[2], $sms->pattern);

            $trace = json_decode($sms->reference_trace, true);
            $trace[time()] = $result;

            if ($result) {
                $sms->reference_id = $result[0]->messageid;
                $sms->reference_status = $result[0]->status;
                $sms->reference_trace = json_encode($trace);
                $sms->note = $result[0]->message;
                $sms->sender = $result[0]->sender;
                $sms->price = $result[0]->cost;

                $sms->status = SmsFieldStatusEnum::SENT;

                $sms->save();
            } else {
                Log::info("kavenegar exception: ", $trace);
                throw new Exception('fail send message to user');
            }
        } catch (ApiException|HttpException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * get balance kavenegar
     *
     * @param SmsGateway $smsGateway
     *
     * @return float
     */
    public function balance(SmsGateway $smsGateway): float
    {
        return 0;
    }

    /**
     * Get status of reference
     *
     * @param int $referenceStatus
     *
     * @return string
     */
    public function referenceStatus(int $referenceStatus): string
    {
        $results = [
            '1' => 'در صف ارسال قرار دارد',
            '2' => 'زمان بندی شده (ارسال در تاریخ معین)',
            '4' => 'ارسال شده به مخابرات',
            '5' => 'ارسال شده به مخابرات (همانند وضعیت 4)',
            '6' => 'خطا در ارسال پیام که توسط سر شماره پیش می آید و به معنی عدم رسیدن پیامک می‌باشد',
            '10' => 'رسیده به گیرنده',
            '11' => 'نرسیده به گیرنده ، این وضعیت به دلایلی از جمله خاموش یا خارج از دسترس بودن گیرنده اتفاق می افتد',
            '13' => 'ارسال پیام از سمت کاربر لغو شده یا در ارسال آن مشکلی پیش آمده که هزینه آن به حساب برگشت داده می‌شود',
            '14' => 'بلاک شده است، عدم تمایل گیرنده به دریافت پیامک از خطوط تبلیغاتی که هزینه آن به حساب برگشت داده می‌شود',
            '100' => 'شناسه پیامک نامعتبر است ( به این معنی که شناسه پیام در پایگاه داده کاوه نگار ثبت نشده است یا متعلق به شما نمی‌باشد)'
        ];

        return $results[$referenceStatus] ?? 'نامشخص';
    }
}
