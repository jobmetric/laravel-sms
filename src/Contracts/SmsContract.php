<?php

namespace JobMetric\Sms\Contracts;

use JobMetric\Sms\Models\Sms;
use JobMetric\Sms\Models\SmsGateway;

interface SmsContract
{
    /**
     * Get Driver Name
     *
     * @return string
     */
    public function getDriverName(): string;

    /**
     * Get Fields
     *
     * @return array
     */
    public function getFields(): array;

    /**
     * Set params
     *
     * @param SmsGateway $smsGateway
     *
     * @return void
     */
    public function setParams(SmsGateway $smsGateway): void;

    /**
     * Send sms
     *
     * @param Sms $sms
     *
     * @return void
     */
    public function send(Sms $sms): void;

    /**
     * Get balance gateway.
     *
     * @param SmsGateway $smsGateway
     *
     * @return float
     */
    public function balance(SmsGateway $smsGateway): float;
}
