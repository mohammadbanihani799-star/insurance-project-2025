<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendNafathCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only authenticated super admins can send codes
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
            'request_id' => ['required', 'integer', 'exists:insurance_requests,id'],
            'action' => ['nullable', 'string', 'in:approve,reject,pending'],
            'redirect_route' => ['nullable', 'string', 'in:' . $this->getAllowedRedirectRoutes()],
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
            'request_id' => 'معرف الطلب',
            'action' => 'الإجراء',
            'redirect_route' => 'مسار إعادة التوجيه',
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
            'request_id.required' => 'معرف الطلب مطلوب',
            'request_id.integer' => 'معرف الطلب يجب أن يكون رقماً صحيحاً',
            'request_id.exists' => 'الطلب غير موجود',
            'action.in' => 'الإجراء غير صالح',
            'redirect_route.in' => 'مسار إعادة التوجيه غير مصرح به',
        ];
    }

    /**
     * Get allowed redirect routes as comma-separated string for validation rule.
     *
     * @return string
     */
    private function getAllowedRedirectRoutes(): string
    {
        return implode(',', $this->allowedRedirectRoutes());
    }

    /**
     * Get list of allowed redirect routes.
     *
     * @return array<string>
     */
    public function allowedRedirectRoutes(): array
    {
        return [
            'super_admin.insurance_requests-index',
            'super_admin.insurance_requests-show',
            'super_admin.insurance_requests-edit',
            'super_admin.realtime-dashboard',
            'super_admin.dashboard',
        ];
    }

    /**
     * Get the validated redirect route or return default.
     *
     * @return string
     */
    public function getRedirectRoute(): string
    {
        $route = $this->validated()['redirect_route'] ?? null;
        
        if ($route && in_array($route, $this->allowedRedirectRoutes(), true)) {
            return $route;
        }

        return 'super_admin.insurance_requests-index';
    }
}
