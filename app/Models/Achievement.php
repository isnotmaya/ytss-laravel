<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = 'achievement';

    protected $fillable = [
        'id_kelompok_kelas',
        'judul',
        'deskripsi',
        'tropi',
        'gambar',
    ];

    public function kelompokKelas()
    {
        return $this->belongsTo(KelompokKelas::class, 'id_kelompok_kelas');
    }
    public function achievements()
    {
        $achievements = Achievement::with('kelompokKelas')->get();

        return view('achievements', compact('achievements'));
    }
}
