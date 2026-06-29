<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokKelas extends Model
{
    protected $table = 'kelompok_kelas';

    protected $fillable = [
        'nama_kelompok',
        'dari_tahun_kelahiran',
        'sampai_tahun_kelahiran',
        'upload_kelompok_kelas',
        'keterangan_kelompok_kelas'
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelompok_kelas');
    }
}
