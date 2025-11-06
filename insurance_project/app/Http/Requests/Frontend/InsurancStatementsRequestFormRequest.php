<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $full_name
 * @property string $identity_number
 * @property string $mobile_number
 * @property string $birth_date
 * @property string $region
 * @property string $city
 * @property string $driving_years
 * @property int $insurance_type
 * @property string $usage_category
 * @property string $policy_start_date
 * @property string $vehicle_type
 * @property string $vehicle_model
 * @property int $manufacturing_year
 * @property string $maintenance_type
 * @property float $approximate_price
 * @property string $has_additional_driver
 * @property string $driver_name
 * @property string $driver_identity_number
 * @property string $driver_mobile_number
 * @property string $driver_birth_date
 * @property string $driver_driving_years
 * @property int $driver_driving_percentage
 */
class InsurancStatementsRequestFormRequest extends FormRequest
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
        $rules =  [
            // Personal Information
            'full_name' => 'required|string|max:255',
            'identity_number' => 'required|string|regex:/^[12][0-9]{9}$/',
            'mobile_number' => 'required|string|regex:/^05[0-9]{8}$/',
            'birth_date' => 'required|date|before:-18 years',
            'region' => 'required|string',
            'city' => 'required|string',
            'driving_years' => 'required|string',
            
            // Insurance Information
            'insurance_type' => 'required|integer|in:1,2',
            'usage_category' => 'required|string|in:personal,commercial,taxi,transport',
            'policy_start_date' => 'required|date|after_or_equal:today',
            
            // Vehicle Information
            'vehicle_type' => 'required|string',
            'vehicle_model' => 'required|string|max:255',
            'manufacturing_year' => 'required|integer|min:1990|max:2026',
            'maintenance_type' => 'required|string|in:agency,workshop',
            'approximate_price' => 'required|numeric|min:1000|max:99999999',
            
            // Additional Driver (conditional)
            'has_additional_driver' => 'nullable|string|in:yes,no',
            'driver_name' => 'required_if:has_additional_driver,yes|string|max:255',
            'driver_identity_number' => 'required_if:has_additional_driver,yes|string|regex:/^[12][0-9]{9}$/',
            'driver_mobile_number' => 'required_if:has_additional_driver,yes|string|regex:/^05[0-9]{8}$/',
            'driver_birth_date' => 'required_if:has_additional_driver,yes|date|before:-18 years',
            'driver_driving_years' => 'required_if:has_additional_driver,yes|string',
            'driver_driving_percentage' => 'required_if:has_additional_driver,yes|integer|min:1|max:100',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            // Personal Information
            'full_name.required' => 'الاسم الكامل مطلوب',
            'full_name.string' => 'الاسم الكامل يجب أن يكون نصًا',
            'full_name.max' => 'الاسم الكامل طويل جدًا',
            
            'identity_number.required' => 'رقم الهوية مطلوب',
            'identity_number.regex' => 'رقم الهوية يجب أن يكون 10 أرقام ويبدأ بـ 1 أو 2',
            
            'mobile_number.required' => 'رقم الجوال مطلوب',
            'mobile_number.regex' => 'رقم الجوال يجب أن يبدأ بـ 05 ويتكون من 10 أرقام',
            
            'birth_date.required' => 'تاريخ الميلاد مطلوب',
            'birth_date.date' => 'تاريخ الميلاد غير صحيح',
            'birth_date.before' => 'يجب أن يكون العمر 18 عامًا على الأقل',
            
            'region.required' => 'المنطقة مطلوبة',
            'city.required' => 'المدينة مطلوبة',
            'driving_years.required' => 'عدد سنوات القيادة مطلوب',
            
            // Insurance Information
            'insurance_type.required' => 'نوع التأمين مطلوب',
            'insurance_type.integer' => 'نوع التأمين غير صحيح',
            'insurance_type.in' => 'نوع التأمين غير صالح',
            
            'usage_category.required' => 'فئة الاستعمال مطلوبة',
            'usage_category.in' => 'فئة الاستعمال غير صالحة',
            
            'policy_start_date.required' => 'تاريخ بدء الوثيقة مطلوب',
            'policy_start_date.date' => 'تاريخ بدء الوثيقة غير صحيح',
            'policy_start_date.after_or_equal' => 'تاريخ بدء الوثيقة يجب أن يكون من اليوم أو بعده',
            
            // Vehicle Information
            'vehicle_type.required' => 'نوع المركبة مطلوب',
            'vehicle_model.required' => 'موديل المركبة مطلوب',
            'vehicle_model.max' => 'موديل المركبة طويل جدًا',
            
            'manufacturing_year.required' => 'سنة الصنع مطلوبة',
            'manufacturing_year.integer' => 'سنة الصنع يجب أن تكون رقمًا',
            'manufacturing_year.min' => 'سنة الصنع غير صحيحة',
            'manufacturing_year.max' => 'سنة الصنع غير صحيحة',
            
            'maintenance_type.required' => 'نوع الصيانة مطلوب',
            'maintenance_type.in' => 'نوع الصيانة غير صالح',
            
            'approximate_price.required' => 'السعر التقريبي مطلوب',
            'approximate_price.numeric' => 'السعر التقريبي يجب أن يكون رقمًا',
            'approximate_price.min' => 'السعر التقريبي يجب أن يكون 1000 ريال على الأقل',
            'approximate_price.max' => 'السعر التقريبي كبير جدًا',
            
            // Additional Driver
            'driver_name.required_if' => 'اسم السائق الإضافي مطلوب',
            'driver_identity_number.required_if' => 'رقم هوية السائق الإضافي مطلوب',
            'driver_identity_number.regex' => 'رقم الهوية يجب أن يكون 10 أرقام ويبدأ بـ 1 أو 2',
            'driver_mobile_number.required_if' => 'رقم جوال السائق الإضافي مطلوب',
            'driver_mobile_number.regex' => 'رقم الجوال يجب أن يبدأ بـ 05 ويتكون من 10 أرقام',
            'driver_birth_date.required_if' => 'تاريخ ميلاد السائق الإضافي مطلوب',
            'driver_birth_date.before' => 'يجب أن يكون عمر السائق الإضافي 18 عامًا على الأقل',
            'driver_driving_years.required_if' => 'عدد سنوات قيادة السائق الإضافي مطلوب',
            'driver_driving_percentage.required_if' => 'نسبة قيادة السائق الإضافي مطلوبة',
            'driver_driving_percentage.min' => 'نسبة القيادة يجب أن تكون على الأقل 1%',
            'driver_driving_percentage.max' => 'نسبة القيادة يجب ألا تتجاوز 100%',
        ];
    }
}
