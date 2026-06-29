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
        Schema::create('daftar_beasiswa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_jenis_beasiswa')
                ->constrained('jenis_beasiswa')
                ->cascadeOnDelete();

            $table->string('nama_lengkap');
            $table->string('nik')->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('nomor_hp');
            $table->string('email');

            $table->string('sertifikat_1')->nullable();
            $table->string('sertifikat_2')->nullable();
            $table->string('sertifikat_3')->nullable();
            $table->string('video')->nullable();

            $table->enum('status_pendaftaran', [
                'pending',
                'diterima',
                'ditolak'
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_beasiswa');
    }
};
