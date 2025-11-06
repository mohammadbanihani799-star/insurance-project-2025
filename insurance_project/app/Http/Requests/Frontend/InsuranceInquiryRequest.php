<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InsuranceInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // purpose: new | transfer (mapped from form_type)
            'form_type' => ['required', Rule::in(['new', 'transfer'])],

            // registration type: serial(istimara) | customs
            'vehicle_registration' => ['required', Rule::in(['serial', 'customs'])],

            // national id
            'identity_number' => ['required', 'regex:/^(1|2)\d{9}$/'],

            // seller national id required when transfer
            'seller_identity_number' => [
                'required_if:form_type,transfer',
                'nullable',
                'regex:/^(1|2)\d{9}$/'
            ],

            // VIN required if serial (istimara) - 5 to 17 characters
            'serial_number' => [
                'required_if:vehicle_registration,serial',
                'nullable',
                // Flexible VIN: 5-17 chars without I,O,Q
                'regex:/^[A-HJ-NPR-Z0-9]{5,17}$/'
            ],

            // customs card required if customs
            'customs_card' => [
                'required_if:vehicle_registration,customs',
                'nullable',
                // 10-15 digits
                'regex:/^\d{10,15}$/'
            ],

            // local phone (optional)
            'phone' => ['nullable', 'regex:/^5\d{8}$/'],

            // captcha numeric 4-8 digits (mapped from captcha_verification)
            'captcha_verification' => ['required', 'regex:/^\d{4,8}$/'],

            // agreement checkbox
            'agreement' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'form_type.required' => 'الرجاء اختيار الغرض من التأمين.',
            'form_type.in' => 'قيمة الغرض غير صحيحة.',

            'vehicle_registration.required' => 'الرجاء اختيار نوع تسجيل المركبة.',
            'vehicle_registration.in' => 'قيمة نوع التسجيل غير صحيحة.',

            'identity_number.required' => 'رقم الهوية/الإقامة مطلوب.',
            'identity_number.regex' => 'رقم الهوية/الإقامة يجب أن يبدأ بـ 1 أو 2 وطوله 10 أرقام.',

            'seller_identity_number.required_if' => 'رقم هوية/إقامة البائع مطلوب عند اختيار نقل ملكية.',
            'seller_identity_number.regex' => 'رقم هوية/إقامة البائع يجب أن يبدأ بـ 1 أو 2 وطوله 10 أرقام.',

            'serial_number.required_if' => 'الرقم التسلسلي (الشاص) مطلوب مع اختيار الاستمارة.',
            'serial_number.regex' => 'الرقم التسلسلي يجب أن يكون من 5 إلى 17 خانة بحروف/أرقام بدون I,O,Q.',

            'customs_card.required_if' => 'رقم البطاقة الجمركية مطلوب عند اختيار بطاقة جمركية.',
            'customs_card.regex' => 'رقم البطاقة الجمركية يجب أن يكون أرقامًا بطول 10 إلى 15.',

            'phone.regex' => 'رقم الجوال يجب أن يكون بصيغة محلية (5 ثم 8 أرقام).',

            'captcha_verification.required' => 'رمز التحقق مطلوب.',
            'captcha_verification.regex' => 'رمز التحقق غير صالح.',

            'agreement.accepted' => 'يجب الموافقة على منح الحق بالاستعلام قبل المتابعة.',
        ];
    }
}
