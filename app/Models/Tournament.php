<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $table = 'tournament';

    protected $fillable = [
        'id_kelompok_kelas',
        'judul',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'deskripsi',
    ];

    public function kelompokKelas()
    {
        return $this->belongsTo(
            KelompokKelas::class,
            'id_kelompok_kelas'
        );
    }
}