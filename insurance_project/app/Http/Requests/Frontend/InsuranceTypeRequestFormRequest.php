<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $insurance_id
 */
class InsuranceTypeRequestFormRequest extends FormRequest
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
            'insurance_id' => 'required|integer|exists:insurances,id',
        ];
    }

    public function messages()
    {
        return [
            'insurance_id.required' => 'Insurance selection is required !!',
            'insurance_id.integer' => 'Insurance ID must be an integer !!',
            'insurance_id.exists' => 'Selected insurance does not exist !!',
        ];
    }
}
