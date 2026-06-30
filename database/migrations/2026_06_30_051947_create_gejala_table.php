<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gejala', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 5)->unique(); // G01..G25
            $table->text('nama_gejala');
            $table->enum('kategori', ['fisik', 'emosi', 'kognitif', 'perilaku', 'kritis']);
            $table->decimal('cf_pakar', 3, 2); // 0.00 - 1.00
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'urutan'], 'idx_gejala_aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gejala');
    }
};