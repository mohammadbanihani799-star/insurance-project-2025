<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insurance_requests', function (Blueprint $table) {
            // Safe indexes to speed up admin listings and lookups
            if (!Schema::hasColumn('insurance_requests', 'identity_number')) {
                return; // nothing to index if base table missing
            }
            $table->index('identity_number', 'ir_identity_idx');
            $table->index('insurance_category', 'ir_category_idx');
            $table->index('created_at', 'ir_created_idx');
        });
    }

    public function down(): void
    {
        Schema::table('insurance_requests', function (Blueprint $table) {
            $table->dropIndex('ir_identity_idx');
            $table->dropIndex('ir_category_idx');
            $table->dropIndex('ir_created_idx');
        });
    }
};
