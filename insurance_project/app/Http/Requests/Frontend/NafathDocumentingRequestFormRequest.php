<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $user_name
 * @property string $password
 */
class NafathDocumentingRequestFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_name' => ['required', 'string', 'max:191'],
            'password'  => ['required', 'string', 'max:191'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_name.required' => 'Username / National ID is required !!',
            'password.required'  => 'Password is required !!',
        ];
    }
}
