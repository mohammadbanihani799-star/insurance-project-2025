<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\InsuranceRequest\SendNafathCodeRequestFormRequest;
use App\Models\Insurance;
use App\Models\InsuranceRequest;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use App\Traits\UploadImageTrait;

class InsuranceRequestsBackendController extends Controller
{
    use UploadImageTrait;

    public function index(Request $request, Route $route)
    {
        try {
            $insuranceRequests = InsuranceRequest::orderBy('created_at', 'desc')->get();
            return view('admin.insurance_requests.index', compact('insuranceRequests'));
        } catch (\Throwable $th) {
            return $this->handleException($th, $route);
        }
    }

    // Lightweight API for polling recent stats (admin dashboard auto-refresh)
    public function summary()
    {
        $count = InsuranceRequest::count();
        $latest = InsuranceRequest::orderByDesc('id')->first(['id','created_at']);
        return response()->json([
            'total' => $count,
            'latest_id' => optional($latest)->id,
            'latest_at' => optional($latest)->created_at,
            'generated_at' => now()->toISOString(),
        ]);
    }

    // ========================================================================
    // ============================ Show Function =============================
    // ========================================================================
    public function show($id, Route $route)
    {
        try {
            $insuranceRequest = InsuranceRequest::find($id);
            
            if (!$insuranceRequest) {
                return redirect()
                    ->route('super_admin.insurances-index')
                    ->with('danger', 'This data is not in the records');
            }
            
            return view('admin.insurance_requests.show', compact('insuranceRequest'));
        } catch (\Throwable $th) {
            return $this->handleException($th, $route);
        }
    }

    // ========================================================================
    // ======================== Soft Delete Function ==========================
    // ========================================================================
    public function softDelete($id, Route $route)
    {
        try {
            $insurance = InsuranceRequest::find($id);
            
            if (!$insurance) {
                return redirect()->back()->with('danger', 'This data is not in the records');
            }
            
            DB::transaction(function () use ($insurance) {
                $insurance->delete();
            });
            
            return redirect()->back()->with('success', 'The Deletion process has been successful');
        } catch (\Throwable $th) {
            return $this->handleException($th, $route);
        }
    }

    // ========================================================================
    // ====================== Show Soft Delete Function =======================
    // ========================================================================
    public function showSoftDelete(Request $request, Route $route)
    {
        try {
            $insurances = Insurance::onlyTrashed()
                ->orderBy('created_at', 'asc')
                ->get();
                
            return view('admin.insurances.trashed', compact('insurances'));
        } catch (\Throwable $th) {
            return $this->handleException($th, $route);
        }
    }

    // ========================================================================
    // ==================== Soft Delete Restore Function ======================
    // ========================================================================
    public function softDeleteRestore($id, Route $route)
    {
        try {
            $insurance = Insurance::onlyTrashed()->find($id);
            
            if (!$insurance) {
                return redirect()->back()->with('danger', 'This section does not exist in the records');
            }
            
            DB::transaction(function () use ($insurance) {
                $insurance->restore();
            });
            
            return redirect()
                ->route('super_admin.insurances-showSoftDelete')
                ->with('success', 'Restore Completed Successfully');
        } catch (\Throwable $th) {
            return $this->handleException($th, $route);
        }
    }

    // ========================================================================
    // ====================== Send Nafath Code Function =======================
    // ========================================================================
    public function sendNafathCode($id, Route $route)
    {
        try {
            $insuranceRequest = InsuranceRequest::find($id);
            
            if (!$insuranceRequest) {
                return redirect()
                    ->route('super_admin.insurance_requests-index')
                    ->with('danger', 'This data is not in the records');
            }
            
            return view('admin.insurance_requests.send_nafath_code', compact('insuranceRequest'));
        } catch (\Throwable $th) {
            return $this->handleException($th, $route);
        }
    }

    // ========================================================================
    // ================== Send Nafath Code Request Function ===================
    // ========================================================================
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

            // تحديث في transaction
            DB::transaction(function () use ($insuranceRequest, $nafath) {
                $insuranceRequest->update(['nafath_code' => $nafath]);
            });

            // Return خارج transaction
            return redirect()
                ->route('super_admin.insurance_requests-index')
                ->with('success', 'Nafath Code Added Successfully');

        } catch (\Throwable $th) {
            return $this->handleException($th, $route);
        }
    }

    // ========================================================================
    // ===================== Handle Exception (DRY Method) ====================
    // ========================================================================
    private function handleException(\Throwable $th, Route $route)
    {
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
