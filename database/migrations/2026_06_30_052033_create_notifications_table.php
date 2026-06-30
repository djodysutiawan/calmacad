<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('konsultasi_id')
                ->nullable()
                ->constrained('konsultasi')
                ->nullOnDelete();
            $table->enum('type', ['reminder', 'broadcast', 'kritis', 'info'])->default('info');
            $table->string('title', 150);
            $table->text('body');
            $table->json('data')->nullable(); // payload tambahan
            $table->timestamp('scheduled_at');
            $table->timestamp('sent_at')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed', 'cancelled'])->default('pending');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'status'], 'idx_notif_user_status');
            $table->index(['scheduled_at', 'status'], 'idx_notif_scheduled');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};