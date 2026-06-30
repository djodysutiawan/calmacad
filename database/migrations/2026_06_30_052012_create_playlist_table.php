<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('playlist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tingkat_stres_id')
                ->constrained('tingkat_stres')
                ->cascadeOnDelete();
            $table->string('judul_lagu', 200);
            $table->string('artis', 150);
            $table->text('keterangan_terapeutik')->nullable();
            $table->string('spotify_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('cover_url')->nullable();
            $table->integer('urutan')->default(0);

            $table->index('tingkat_stres_id', 'idx_playlist_tingkat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('playlist');
    }
};