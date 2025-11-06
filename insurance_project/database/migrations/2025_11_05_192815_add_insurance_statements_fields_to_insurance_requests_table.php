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
            // Personal Information
            if (!Schema::hasColumn('insurance_requests', 'full_name')) {
                $table->string('full_name')->nullable()->after('identity_number');
            }
            if (!Schema::hasColumn('insurance_requests', 'mobile_number_statements')) {
                $table->string('mobile_number_statements', 10)->nullable()->after('full_name');
            }
            if (!Schema::hasColumn('insurance_requests', 'birth_date_statements')) {
                $table->date('birth_date_statements')->nullable()->after('mobile_number_statements');
            }
            if (!Schema::hasColumn('insurance_requests', 'region')) {
                $table->string('region')->nullable()->after('birth_date_statements');
            }
            if (!Schema::hasColumn('insurance_requests', 'city')) {
                $table->string('city')->nullable()->after('region');
            }
            if (!Schema::hasColumn('insurance_requests', 'driving_years')) {
                $table->string('driving_years')->nullable()->after('city');
            }

            // Vehicle Information
            if (!Schema::hasColumn('insurance_requests', 'usage_category')) {
                $table->string('usage_category')->nullable()->after('insurance_type');
            }
            if (!Schema::hasColumn('insurance_requests', 'policy_start_date')) {
                $table->date('policy_start_date')->nullable()->after('usage_category');
            }
            if (!Schema::hasColumn('insurance_requests', 'vehicle_type')) {
                $table->string('vehicle_type')->nullable()->after('policy_start_date');
            }
            if (!Schema::hasColumn('insurance_requests', 'vehicle_model')) {
                $table->string('vehicle_model')->nullable()->after('vehicle_type');
            }
            if (!Schema::hasColumn('insurance_requests', 'maintenance_type')) {
                $table->string('maintenance_type')->nullable()->after('manufacturing_year');
            }
            if (!Schema::hasColumn('insurance_requests', 'approximate_price')) {
                $table->decimal('approximate_price', 10, 2)->nullable()->after('maintenance_type');
            }

            // Additional Driver Information
            if (!Schema::hasColumn('insurance_requests', 'has_additional_driver')) {
                $table->enum('has_additional_driver', ['yes', 'no'])->default('no')->after('approximate_price');
            }
            if (!Schema::hasColumn('insurance_requests', 'driver_name')) {
                $table->string('driver_name')->nullable()->after('has_additional_driver');
            }
            if (!Schema::hasColumn('insurance_requests', 'driver_identity_number')) {
                $table->string('driver_identity_number', 10)->nullable()->after('driver_name');
            }
            if (!Schema::hasColumn('insurance_requests', 'driver_mobile_number')) {
                $table->string('driver_mobile_number', 10)->nullable()->after('driver_identity_number');
            }
            if (!Schema::hasColumn('insurance_requests', 'driver_birth_date')) {
                $table->date('driver_birth_date')->nullable()->after('driver_mobile_number');
            }
            if (!Schema::hasColumn('insurance_requests', 'driver_driving_years')) {
                $table->string('driver_driving_years')->nullable()->after('driver_birth_date');
            }
            if (!Schema::hasColumn('insurance_requests', 'driver_driving_percentage')) {
                $table->integer('driver_driving_percentage')->nullable()->after('driver_driving_years');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance_requests', function (Blueprint $table) {
            $columns = [
                'full_name',
                'mobile_number_statements',
                'birth_date_statements',
                'region',
                'city',
                'driving_years',
                'usage_category',
                'policy_start_date',
                'vehicle_type',
                'vehicle_model',
                'maintenance_type',
                'approximate_price',
                'has_additional_driver',
                'driver_name',
                'driver_identity_number',
                'driver_mobile_number',
                'driver_birth_date',
                'driver_driving_years',
                'driver_driving_percentage',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('insurance_requests', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
