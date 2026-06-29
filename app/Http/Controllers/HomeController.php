<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KelompokKelas;
use App\Models\Achievement;
use App\Models\ProfileSekolah;
use App\Models\JadwalLatihan;
use App\Models\Agenda;
use App\Models\Tournament;
use App\Models\Siswa;


class HomeController extends Controller
{
    public function index()
    {
        $kelompokKelas = KelompokKelas::all();
        foreach ($kelompokKelas as $kk) {
            $kk->banner_exists = !empty($kk->upload_kelompok_kelas) && file_exists(public_path($kk->upload_kelompok_kelas));
        }

        $achievements = Achievement::with('kelompokKelas')
            ->latest()
            ->take(3)
            ->get();
        foreach ($achievements as $ach) {
            $ach->gambar_exists = !empty($ach->gambar) && file_exists(public_path($ach->gambar));
        }

        $stats = $this->getPortalStats();
        $stats['tournament'] = Tournament::count();
        dd([
            'path' => $kelompokKelas->first()->upload_kelompok_kelas,
            'public_path' => public_path($kelompokKelas->first()->upload_kelompok_kelas),
            'exists' => file_exists(public_path($kelompokKelas->first()->upload_kelompok_kelas)),
        ]);
        return view('home', compact(
            'kelompokKelas',
            'achievements',
            'stats'
        ));
    }

    public function achievements()
    {
        $achievements = Achievement::with('kelompokKelas')->latest()->get();
        foreach ($achievements as $ach) {
            $ach->gambar_exists = !empty($ach->gambar) && file_exists(public_path($ach->gambar));
        }

        return view('achievements', compact('achievements'));
    }

    public function profileSekolah()
    {
        $profileSekolah = ProfileSekolah::first();
        if ($profileSekolah) {
            $profileSekolah->photo_exists = !empty($profileSekolah->upload_photo_profile_sekolah) && file_exists(public_path($profileSekolah->upload_photo_profile_sekolah));
        }

        return view('profile', compact('profileSekolah'));
    }
    public function schedule()
    {
        $schedules = JadwalLatihan::with('kelompokKelas')
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        return view('schedule', compact('schedules'));
    }

    public function agenda()
    {
        $agendas = Agenda::with('kelompokKelas')
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        return view('agenda', compact('agendas'));
    }

    public function tournament()
    {
        $tournaments = Tournament::with('kelompokKelas')
            ->orderBy('tanggal')
            ->get();

        return view('tournament', compact('tournaments'));
    }
}
