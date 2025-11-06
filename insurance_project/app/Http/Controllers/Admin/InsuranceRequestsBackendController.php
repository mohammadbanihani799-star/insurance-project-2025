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

    public function sendNafathCodeRequest(SendNafathCodeRequestFormRequest $request, Route $route, $id)
    {
        try {
            $insuranceRequest = InsuranceRequest::find($id);

            // Early return pattern - تحقق من وجود السجل أولاً
            if (! $insuranceRequest) {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }

            // استخراج البيانات قبل الـ transaction
            $validated = $request->validated();
            $nafath = $validated['nafath_code'] ?? null;

            // تنفيذ التحديث فقط داخل الـ transaction
            DB::transaction(function () use ($insuranceRequest, $nafath) {
                $insuranceRequest->update(['nafath_code' => $nafath]);
            }); // ✅ إغلاق صحيح

            // ✅ return خارج الـ transaction
            return redirect()
                ->route('super_admin.insurance_requests-index')
                ->with('success', 'Nafath Code Added Successfully');
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
}
