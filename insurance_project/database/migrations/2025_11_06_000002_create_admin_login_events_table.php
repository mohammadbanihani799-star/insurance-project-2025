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
        Schema::create('admin_login_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('event', 24)->index(); // login_success | login_failed | logout
            $table->string('ip', 64)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device_id', 64)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['admin_id', 'event', 'created_at']);
            $table->index(['ip', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_login_events');
    }
};
