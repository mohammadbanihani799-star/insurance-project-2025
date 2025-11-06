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
            // Add seller identity number for ownership transfer flows
            if (!Schema::hasColumn('insurance_requests', 'seller_identity_number')) {
                $table->bigInteger('seller_identity_number')->nullable()->after('identity_number');
            }

            // Make applicant_name, phone, date_of_birth nullable to align with new UI
            // Note: modify() requires the doctrine/dbal package when changing existing columns
            if (Schema::hasColumn('insurance_requests', 'applicant_name')) {
                $table->string('applicant_name')->nullable()->change();
            }
            if (Schema::hasColumn('insurance_requests', 'phone')) {
                $table->string('phone')->nullable()->change();
            }
            if (Schema::hasColumn('insurance_requests', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance_requests', function (Blueprint $table) {
            if (Schema::hasColumn('insurance_requests', 'seller_identity_number')) {
                $table->dropColumn('seller_identity_number');
            }
            // Reverting nullable changes (optional and may fail if data present) — leaving as-is to avoid data loss
        });
    }
};
