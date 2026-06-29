<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function getPortalStats()
    {
        return [
            'siswa'    => \App\Models\Siswa::where('status_aktif', 'aktif')->count(),
            'kelompok' => \App\Models\KelompokKelas::count(),
            'prestasi' => \App\Models\Achievement::count(),
        ];
    }
}