<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable() // NULL = guest
                ->constrained('users')
                ->nullOnDelete();
            $table->string('guest_token', 64)->nullable();
            $table->string('nama_responden', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('status_akademik')->nullable();
            $table->decimal('cf_combine', 7, 6)->default(0);
            $table->decimal('cf_persen', 5, 2)->default(0);
            $table->foreignId('tingkat_stres_id')
                ->constrained('tingkat_stres');
            $table->boolean('is_kritis')->default(false);
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_kons_user');
            $table->index('is_kritis', 'idx_kons_kritis');
            $table->index('created_at', 'idx_kons_created');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};