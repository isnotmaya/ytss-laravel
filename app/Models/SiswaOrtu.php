<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaOrtu extends Model
{
    protected $table = 'siswa_ortu';

    protected $fillable = [
        'id_siswa',
        'kd_users',
        'nama_ayah',
        'pekerjaan_ayah',
        'nomor_hp_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'nomor_hp_ibu',
        'upload_foto',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'kd_users', 'kd_users');
    }
}
