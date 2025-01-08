<?php

namespace JobMetric\Sms\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JobMetric\Sms\Models\SmsGateway;

/**
 * @extends Factory<SmsGateway>
 */
class SmsGatewayFactory extends Factory
{
    protected $model = SmsGateway::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $drivers = getDriverNames(config('sms.namespaces'));
        $driver = $this->faker->randomElement($drivers);

        $driverClass = new $driver;
        $fields = $driverClass->getFields();

        $fields_values = [];
        foreach ($fields as $field) {
            $fields_values[$field] = $this->faker->word;
        }

        return [
            'name' => $this->faker->name,
            'driver' => $driver,
            'fields' => $fields_values,
            'default' => false,
        ];
    }

    /**
     * set name
     *
     * @param string $name
     *
     * @return static
     */
    public function setName(string $name): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => $name
        ]);
    }

    /**
     * set driver
     *
     * @param string $driver
     *
     * @return static
     */
    public function setDriver(string $driver): static
    {
        return $this->state(fn(array $attributes) => [
            'driver' => $driver
        ]);
    }

    /**
     * set fields
     *
     * @param array $fields
     *
     * @return static
     */
    public function setFields(array $fields): static
    {
        return $this->state(fn(array $attributes) => [
            'fields' => $fields
        ]);
    }

    /**
     * set default
     *
     * @return static
     */
    public function setDefault(): static
    {
        return $this->state(fn(array $attributes) => [
            'default' => true
        ]);
    }
}
