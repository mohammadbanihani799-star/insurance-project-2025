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
        Schema::create('insurance_visits', function (Blueprint $table) {
            $table->id();
            $table->string('device_id', 64)->index();
            $table->string('session_id', 64)->nullable()->index();
            $table->string('path', 500);
            $table->string('step_key', 100)->nullable();
            $table->json('meta')->nullable();
            $table->timestamp('visited_at')->useCurrent();
            $table->timestamps();

            $table->index(['device_id', 'visited_at']);
            $table->index(['step_key', 'visited_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_visits');
    }
};
