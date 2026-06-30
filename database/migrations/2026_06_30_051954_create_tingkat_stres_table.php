<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tingkat_stres', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 5)->unique(); // S00..S04
            $table->string('nama', 50);
            $table->text('definisi');
            $table->text('ciri_khas')->nullable();
            $table->decimal('min_cf', 5, 4);
            $table->decimal('max_cf', 5, 4);
            $table->integer('min_gejala')->default(0);
            $table->integer('max_gejala')->nullable();
            $table->string('warna_hex', 7)->default('#1E40AF');
            $table->string('icon', 50)->nullable();
            $table->integer('urutan')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tingkat_stres');
    }
};