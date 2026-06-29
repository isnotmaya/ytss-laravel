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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_kelompok_kelas')
                ->constrained('kelompok_kelas')
                ->cascadeOnDelete();

            $table->string('kd_users', 6)->unique();

            $table->string('nis')->unique();

            $table->string('nama_lengkap');

            $table->string('tempat_lahir')->nullable();

            $table->date('tanggal_lahir');

            $table->enum('jenis_kelamin', ['L', 'P']);

            $table->text('alamat');

            $table->string('nomor_hp');

            $table->string('asal_sekolah')->nullable();

            $table->string('upload_akte')->nullable();

            $table->string('upload_kk')->nullable();

            $table->string('upload_ijazah')->nullable();

            $table->string('upload_foto')->nullable();

            $table->enum('status_aktif', [
                'daftar-reguler',
                'daftar-beasiswa',
                'daftar-tolak',
                'aktif',
                'cuti',
                'tidak-aktif'
            ]);

            $table->string('beasiswa_sertifikat_1')->nullable();

            $table->string('beasiswa_sertifikat_2')->nullable();

            $table->string('beasiswa_sertifikat_3')->nullable();

            $table->string('beasiswa_video')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
