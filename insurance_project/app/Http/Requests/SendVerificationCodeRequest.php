<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendVerificationCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only authenticated super admins can send verification codes
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code_type' => ['required', 'string', 'in:nafath_code,phone_otp,card_otp,pin_code'],
            'code_value' => ['required', 'string', 'max:20'],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'code_type' => 'نوع الكود',
            'code_value' => 'قيمة الكود',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'code_type.required' => 'نوع الكود مطلوب',
            'code_type.in' => 'نوع الكود غير صالح',
            'code_value.required' => 'قيمة الكود مطلوبة',
            'code_value.max' => 'قيمة الكود يجب ألا تتجاوز 20 حرفاً',
        ];
    }

    /**
     * Get the code type from validated data.
     *
     * @return string
     */
    public function getCodeType(): string
    {
        return $this->validated()['code_type'];
    }

    /**
     * Get the code value from validated data.
     *
     * @return string
     */
    public function getCodeValue(): string
    {
        return $this->validated()['code_value'];
    }

    /**
     * Get the database column name for the code type.
     *
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->getCodeType();
    }
}
