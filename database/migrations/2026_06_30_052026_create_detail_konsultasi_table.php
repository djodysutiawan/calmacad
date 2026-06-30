<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_konsultasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konsultasi_id')
                ->constrained('konsultasi')
                ->cascadeOnDelete();
            $table->foreignId('gejala_id')
                ->constrained('gejala');
            $table->decimal('cf_user', 3, 2); // pilihan user: 0 / 0.4 / 0.6 / 0.8 / 1.0
            $table->decimal('cf_hasil', 7, 6); // cf_pakar x cf_user

            $table->unique(['konsultasi_id', 'gejala_id'], 'uk_kons_gejala');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_konsultasi');
    }
};