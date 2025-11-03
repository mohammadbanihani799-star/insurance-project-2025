<?php

namespace App\Providers;

use App\Models\Insurance;
use App\Models\InsuranceRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
         try {
             \DB::connection()->getPdo();
            
            View::composer('*', function ($view) {
                $insurances = Insurance::get();
                $insuranceRequests = InsuranceRequest::get();
                view()->share([
                    'insurances' => $insurances,
                    'insuranceRequests' => $insuranceRequests,
                ]);
            });
        } catch (\Exception $e) {
            // إذا فشل الاتصال، لا تحمل البيانات
            View::composer('*', function ($view) {
                view()->share([
                    'insurances' => collect(),
                    'insuranceRequests' => collect(),
                ]);
            });
        }
    }
}
