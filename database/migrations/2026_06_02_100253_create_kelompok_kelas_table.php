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
        Schema::create('kelompok_kelas', function (Blueprint $table) {
            $table->id();

            $table->string('nama_kelompok');

            $table->year('dari_tahun_kelahiran');

            $table->year('sampai_tahun_kelahiran');

            $table->string('upload_kelompok_kelas')->nullable();

            $table->text('keterangan_kelompok_kelas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_kelas');
    }
};
