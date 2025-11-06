<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property float $total
 */
class InsuranceInformationRequestFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'total' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'total.required' => 'Total amount is required !!',
            'total.numeric' => 'Total amount must be a number !!',
            'total.min' => 'Total amount must be at least 0 !!',
        ];
    }
}
