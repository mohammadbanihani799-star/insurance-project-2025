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
            $table->boolean('approved')->default(0)->after('cvv')->comment('0 = قيد المراجعة, 1 = تمت الموافقة, 2 = مرفوض');
            $table->timestamp('approved_at')->nullable()->after('approved')->comment('تاريخ الموافقة');
            $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at')->comment('المسؤول الذي وافق');
            $table->text('approval_notes')->nullable()->after('approved_by')->comment('ملاحظات الموافقة');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance_requests', function (Blueprint $table) {
            $table->dropColumn(['approved', 'approved_at', 'approved_by', 'approval_notes']);
        });
    }
};
