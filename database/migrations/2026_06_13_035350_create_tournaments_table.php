<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournament', function (Blueprint $table) {

            $table->id();

            $table->foreignId('id_kelompok_kelas')
                ->constrained('kelompok_kelas')
                ->cascadeOnDelete();

            $table->string('judul');

            $table->date('tanggal');

            $table->time('jam_mulai');

            $table->time('jam_selesai');

            $table->string('lokasi');

            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament');
    }
};