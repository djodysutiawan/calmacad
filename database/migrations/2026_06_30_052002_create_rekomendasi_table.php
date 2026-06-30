<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekomendasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tingkat_stres_id')
                ->constrained('tingkat_stres')
                ->cascadeOnDelete();
            $table->enum('kategori', ['penanganan', 'healing', 'darurat']);
            $table->string('judul', 200);
            $table->longText('konten');
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->index(['tingkat_stres_id', 'kategori'], 'idx_rek_tingkat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekomendasi');
    }
};