<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // جدول تتبع الأجهزة النشطة
        Schema::create('active_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('session_id')->unique();
            $table->string('device_type')->nullable(); // desktop, mobile, tablet
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('platform')->nullable(); // Windows, macOS, Linux, Android, iOS
            $table->string('platform_version')->nullable();
            $table->ipAddress('ip_address');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('user_agent');
            $table->timestamp('last_activity');
            $table->timestamp('login_at');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
            
            // Indexes for performance
            $table->index('user_id');
            $table->index('session_id');
            $table->index('last_activity');
            $table->index('is_admin');
        });

        // جدول محاولات تسجيل الدخول
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('email')->nullable();
            $table->ipAddress('ip_address');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('device_type')->nullable();
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->text('user_agent');
            $table->boolean('successful')->default(false);
            $table->string('failure_reason')->nullable();
            $table->boolean('is_admin_attempt')->default(false);
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('ip_address');
            $table->index('successful');
            $table->index('is_admin_attempt');
            $table->index('created_at');
        });

        // جدول الإشعارات الأمنية
        Schema::create('security_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // login_success, login_failed, suspicious_activity, new_device
            $table->text('message');
            $table->json('data')->nullable(); // بيانات إضافية
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('type');
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_notifications');
        Schema::dropIfExists('login_attempts');
        Schema::dropIfExists('active_devices');
    }
};
