<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'id_kelompok_kelas',
        'kd_users',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'nomor_hp',
        'asal_sekolah',
        'upload_akte',
        'upload_kk',
        'upload_ijazah',
        'upload_nisn',
        'upload_foto',
        'status_aktif',
        'beasiswa_sertifikat_1',
        'beasiswa_sertifikat_2',
        'beasiswa_sertifikat_3',
        'beasiswa_video',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function ortu()
    {
        return $this->hasOne(SiswaOrtu::class, 'id_siswa');
    }

    public function kelompokKelas()
    {
        return $this->belongsTo(KelompokKelas::class, 'id_kelompok_kelas');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'kd_users', 'kd_users');
    }

    public function getInitials()
    {
        $words = explode(' ', trim($this->nama_lengkap));
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        return substr($initials, 0, 2);
    }
}
