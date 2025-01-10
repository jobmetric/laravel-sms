<?php

namespace JobMetric\Sms\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSmsGatewayRequest extends FormRequest
{
    public int|null $sms_gateway_id = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        if (is_null($this->sms_gateway_id)) {
            $sms_gateway_id = $this->route()->parameter('sms_gateway')->id;
        } else {
            $sms_gateway_id = $this->sms_gateway_id;
        }

        return [
            'name' => 'required|string|unique:sms_gateways,name,' . $sms_gateway_id,
            'driver' => 'required|string',
            'fields' => 'array|sometimes',
            'fields.*' => 'required|string',
        ];
    }

    /**
     * Set sms gateway id for validation
     *
     * @param int $sms_gateway_id
     * @return static
     */
    public function setSmsGatewayId(int $sms_gateway_id): static
    {
        $this->sms_gateway_id = $sms_gateway_id;

        return $this;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => trans('sms::base.form.fields.name.title'),
            'driver' => trans('sms::base.form.fields.driver.title'),
        ];
    }
}
