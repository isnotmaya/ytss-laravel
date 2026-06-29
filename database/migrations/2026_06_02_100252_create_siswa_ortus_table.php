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
        Schema::create('siswa_ortu', function (Blueprint $table) {
            $table->id();

            $table->string('kd_users', 6)->nullable();

            $table->string('nama_ayah');

            $table->string('pekerjaan_ayah')->nullable();

            $table->string('nomor_hp_ayah');

            $table->string('nama_ibu');

            $table->string('pekerjaan_ibu')->nullable();

            $table->string('nomor_hp_ibu');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_ortu');
    }
};
