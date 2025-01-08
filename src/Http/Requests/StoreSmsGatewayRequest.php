<?php

namespace JobMetric\Sms\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Throwable;

class StoreSmsGatewayRequest extends FormRequest
{
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
     * @throws Throwable
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:sms_gateways:name',
            'driver' => 'required|string',
            'fields' => 'array|sometimes',
            'fields.*' => 'required|string',
        ];
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
