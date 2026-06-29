<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\JadwalLatihan;
use App\Models\Agenda;
use App\Models\Tournament;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['kelompokKelas', 'ortu', 'user'])
            ->where('kd_users', Auth::user()->kd_users)
            ->firstOrFail();

        if ($siswa->kelompokKelas) {
            $siswa->kelompokKelas->banner_exists = !empty($siswa->kelompokKelas->upload_kelompok_kelas) && file_exists(public_path($siswa->kelompokKelas->upload_kelompok_kelas));
        }

        $stats = [
            'kelompok' => $siswa->kelompokKelas ? $siswa->kelompokKelas->nama_kelompok : 'Belum Ada',
            'agenda_count' => Agenda::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)->count(),
            'tournament_count' => Tournament::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)->count(),
            'achievement_count' => Achievement::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)->count(),
            'status_aktif' => $siswa->status_aktif ?? 'tidak-aktif',
        ];

        $upcomingJadwal = JadwalLatihan::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
            ->orderBy('tanggal', 'asc')
            ->take(3)
            ->get();

        $recentAgenda = Agenda::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
            ->orderBy('tanggal', 'desc')
            ->take(3)
            ->get();

        return view('siswa.dashboard', compact('siswa', 'stats', 'upcomingJadwal', 'recentAgenda'));
    }

    public function orangTua()
    {
        $siswa = Siswa::with('ortu')->where('kd_users', Auth::user()->kd_users)->firstOrFail();
        $ortu = $siswa->ortu;
        return view('siswa.orang-tua', compact('siswa', 'ortu'));
    }

    public function kelompokKelas()
    {
        $siswa = Siswa::with('kelompokKelas')->where('kd_users', Auth::user()->kd_users)->firstOrFail();
        $kelompok = $siswa->kelompokKelas;
        if ($kelompok) {
            $kelompok->banner_exists = !empty($kelompok->upload_kelompok_kelas) && file_exists(public_path($kelompok->upload_kelompok_kelas));
        }
        return view('siswa.kelompok-kelas', compact('siswa', 'kelompok'));
    }

    public function jadwal()
    {
        $siswa = Siswa::where('kd_users', Auth::user()->kd_users)->firstOrFail();
        $jadwals = JadwalLatihan::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
            ->orderBy('tanggal', 'asc')
            ->get();
        return view('siswa.jadwal', compact('siswa', 'jadwals'));
    }

    public function agenda()
    {
        $siswa = Siswa::where('kd_users', Auth::user()->kd_users)->firstOrFail();
        $agendas = Agenda::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
            ->orderBy('tanggal', 'asc')
            ->get();
        return view('siswa.agenda', compact('siswa', 'agendas'));
    }

    public function tournament()
    {
        $siswa = Siswa::where('kd_users', Auth::user()->kd_users)->firstOrFail();
        $tournaments = Tournament::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
            ->orderBy('tanggal', 'asc')
            ->get();
        return view('siswa.tournament', compact('siswa', 'tournaments'));
    }

    public function achievement()
    {
        $siswa = Siswa::where('kd_users', Auth::user()->kd_users)->firstOrFail();
        $achievements = Achievement::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
            ->orderBy('id', 'desc')
            ->get();
        foreach ($achievements as $ach) {
            $ach->gambar_exists = !empty($ach->gambar) && file_exists(public_path($ach->gambar));
        }
        return view('siswa.achievement', compact('siswa', 'achievements'));
    }
}