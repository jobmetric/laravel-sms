<?php

namespace JobMetric\Sms\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JobMetric\Authio\Models\User;
use JobMetric\Sms\Enums\SmsFieldStatusEnum;
use JobMetric\Sms\Models\Sms;
use JobMetric\Sms\Sms as SmsService;

/**
 * @extends Factory<Sms>
 */
class SmsFactory extends Factory
{
    protected $model = Sms::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::query()->get();
        $user = $users->random();

        $note = $this->faker->sentence;
        $processText = SmsService::processText($note);
        return [
            'sms_gateway_id' => null,
            'user_id' => $user->id,
            'mobile_prefix' => $user->mobile_prefix,
            'mobile' => $user->mobile,
            'sender' => $this->faker->phoneNumber,
            'pattern' => 'otp',
            'inputs' => [
                'token' => 12345,
                'token2' => $this->faker->word
            ],
            'note' => $note,
            'note_type' => $processText['type'],
            'page' => $processText['page'],
            'price' => 0,
            'reference_id' => null,
            'reference_status' => null,
            'reference_trace' => null,
            'status' => SmsFieldStatusEnum::DNS(),
        ];
    }

    /**
     * set gateway id
     *
     * @param int $gatewayId
     *
     * @return static
     */
    public function setGatewayId(int $gatewayId): static
    {
        return $this->state(fn(array $attributes) => [
            'sms_gateway_id' => $gatewayId
        ]);
    }
}
