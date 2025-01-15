<?php

namespace JobMetric\Sms\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use JobMetric\Authio\Rules\MobileRule;
use Throwable;

class SendSmsRequest extends FormRequest
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
            'mobile_prefix' => 'required|string|max:20',
            'mobile' => [
                'required',
                'string',
                'max:20',
                new MobileRule('mobile_prefix')
            ],
            'note' => 'required|string|max:500',
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
            'mobile_prefix' => trans('sms::base.list.sms.add_modal.fields.mobile_prefix.title'),
            'mobile' => trans('sms::base.list.sms.add_modal.fields.mobile.title'),
            'note' => trans('sms::base.list.sms.add_modal.fields.note.title'),
        ];
    }
}
