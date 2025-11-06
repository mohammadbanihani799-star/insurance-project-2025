<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApprovalStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only authenticated super admins can update approval status
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
            'status' => ['required', 'string', 'in:approved,rejected,pending'],
            'redirect_url' => ['nullable', 'string', 'in:' . $this->getAllowedRedirectUrls()],
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
            'status' => 'حالة الموافقة',
            'redirect_url' => 'رابط إعادة التوجيه',
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
            'status.required' => 'حالة الموافقة مطلوبة',
            'status.in' => 'حالة الموافقة غير صالحة',
            'redirect_url.in' => 'رابط إعادة التوجيه غير مصرح به',
        ];
    }

    /**
     * Get allowed redirect URLs as comma-separated string for validation rule.
     *
     * @return string
     */
    private function getAllowedRedirectUrls(): string
    {
        return implode(',', $this->allowedRedirectUrls());
    }

    /**
     * Get list of allowed redirect URLs/routes.
     *
     * @return array<string>
     */
    public function allowedRedirectUrls(): array
    {
        return [
            '/',
            '/super_admin/dashboard',
            '/super_admin/insurance_requests',
            '/super_admin/realtime-dashboard',
            'super_admin.dashboard',
            'super_admin.insurance_requests-index',
            'super_admin.realtime-dashboard',
        ];
    }

    /**
     * Get the status from validated data.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->validated()['status'];
    }

    /**
     * Get the validated redirect URL or return default.
     *
     * @return string
     */
    public function getRedirectUrl(): string
    {
        $url = $this->validated()['redirect_url'] ?? '/';
        
        if ($url && in_array($url, $this->allowedRedirectUrls(), true)) {
            return $url;
        }

        return '/';
    }
}
