<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalLatihan extends Model
{
    protected $table = 'jadwal_latihan';

    protected $fillable = [
        'id_kelompok_kelas',
        'judul',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'deskripsi',
    ];
    protected $casts = [
        'tanggal' => 'date',
    ]; 
    public function kelompokKelas()
    {
        return $this->belongsTo(
            KelompokKelas::class,
            'id_kelompok_kelas'
        );
    }
}
