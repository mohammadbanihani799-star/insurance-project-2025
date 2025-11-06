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
        Schema::table('insurance_requests', function (Blueprint $table) {
            // Check if column exists before adding
            if (!Schema::hasColumn('insurance_requests', 'is_active')) {
                $table->boolean('is_active')->default(false)->after('id');
            }
            if (!Schema::hasColumn('insurance_requests', 'last_activity')) {
                $table->timestamp('last_activity')->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('insurance_requests', 'current_route')) {
                $table->string('current_route', 255)->nullable()->after('last_activity');
            }
            
            // User device information
            if (!Schema::hasColumn('insurance_requests', 'user_ip')) {
                $table->string('user_ip', 45)->nullable()->after('current_route');
            }
            if (!Schema::hasColumn('insurance_requests', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('user_ip');
            }
            if (!Schema::hasColumn('insurance_requests', 'device_id')) {
                $table->string('device_id', 255)->nullable()->after('user_agent');
            }
            
            // Approval system columns
            if (!Schema::hasColumn('insurance_requests', 'approval_status')) {
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending')->after('device_id');
            }
            if (!Schema::hasColumn('insurance_requests', 'approval_redirect_url')) {
                $table->string('approval_redirect_url', 500)->nullable()->after('approval_status');
            }
            if (!Schema::hasColumn('insurance_requests', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('approval_redirect_url');
            }
            if (!Schema::hasColumn('insurance_requests', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
            
            // Nafath/OTP codes - skip if already exists
            if (!Schema::hasColumn('insurance_requests', 'phone_otp')) {
                $table->string('phone_otp', 10)->nullable()->after('nafath_code');
            }
            if (!Schema::hasColumn('insurance_requests', 'card_otp')) {
                $table->string('card_otp', 10)->nullable()->after('phone_otp');
            }
            if (!Schema::hasColumn('insurance_requests', 'pin_code')) {
                $table->string('pin_code', 10)->nullable()->after('card_otp');
            }
            
            // Submission tracking
            if (!Schema::hasColumn('insurance_requests', 'submission_count')) {
                $table->integer('submission_count')->default(0)->after('pin_code');
            }
            if (!Schema::hasColumn('insurance_requests', 'first_submission_at')) {
                $table->timestamp('first_submission_at')->nullable()->after('submission_count');
            }
            if (!Schema::hasColumn('insurance_requests', 'last_submission_at')) {
                $table->timestamp('last_submission_at')->nullable()->after('first_submission_at');
            }
        });
        
        // Add indexes in separate statement
        Schema::table('insurance_requests', function (Blueprint $table) {
            // Indexes for performance - skip foreign key for now
            $indexNames = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableIndexes('insurance_requests');
            
            if (!isset($indexNames['insurance_requests_is_active_index']) && Schema::hasColumn('insurance_requests', 'is_active')) {
                $table->index('is_active');
            }
            if (!isset($indexNames['insurance_requests_last_activity_index']) && Schema::hasColumn('insurance_requests', 'last_activity')) {
                $table->index('last_activity');
            }
            if (!isset($indexNames['insurance_requests_user_ip_index']) && Schema::hasColumn('insurance_requests', 'user_ip')) {
                $table->index('user_ip');
            }
            if (!isset($indexNames['insurance_requests_approval_status_index']) && Schema::hasColumn('insurance_requests', 'approval_status')) {
                $table->index('approval_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance_requests', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['approved_by']);
            
            // Drop indexes
            $table->dropIndex(['is_active']);
            $table->dropIndex(['last_activity']);
            $table->dropIndex(['user_ip']);
            $table->dropIndex(['approval_status']);
            
            // Drop columns
            $table->dropColumn([
                'is_active',
                'last_activity',
                'current_route',
                'user_ip',
                'user_agent',
                'device_id',
                'approval_status',
                'approval_redirect_url',
                'approved_by',
                'approved_at',
                'nafath_code',
                'phone_otp',
                'card_otp',
                'pin_code',
                'submission_count',
                'first_submission_at',
                'last_submission_at',
            ]);
        });
    }
};
