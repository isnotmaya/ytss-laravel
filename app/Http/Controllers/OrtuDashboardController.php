<?php

namespace App\Http\Controllers;

use App\Models\SiswaOrtu;
use App\Models\Siswa;
use App\Models\JadwalLatihan;
use App\Models\Agenda;
use App\Models\Tournament;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrtuDashboardController extends Controller
{
    private function getOrtuAndSiswa()
    {
        $ortu = SiswaOrtu::with(['user', 'siswa.kelompokKelas'])
            ->where('kd_users', Auth::user()->kd_users)
            ->first();

        $siswa = $ortu ? $ortu->siswa : null;

        return [$ortu, $siswa];
    }

    public function index()
    {
        list($ortu, $siswa) = $this->getOrtuAndSiswa();

        if ($siswa && $siswa->kelompokKelas) {
            $siswa->kelompokKelas->banner_exists = !empty($siswa->kelompokKelas->upload_kelompok_kelas) && file_exists(public_path($siswa->kelompokKelas->upload_kelompok_kelas));
        }

        $stats = [
            'nama_anak' => $siswa ? $siswa->nama_lengkap : 'Belum Ada',
            'kelompok' => ($siswa && $siswa->kelompokKelas) ? $siswa->kelompokKelas->nama_kelompok : 'Belum Ada',
            'status_anak' => ($siswa && $siswa->status_aktif) ? $siswa->status_aktif : 'tidak-aktif',
        ];

        $upcomingJadwal = [];
        $recentAgenda = [];
        $achievements = [];

        if ($siswa) {
            $upcomingJadwal = JadwalLatihan::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
                ->orderBy('tanggal', 'asc')
                ->take(3)
                ->get();

            $recentAgenda = Agenda::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
                ->orderBy('tanggal', 'desc')
                ->take(3)
                ->get();

            $achievements = Achievement::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
                ->orderBy('id', 'desc')
                ->take(3)
                ->get();

            foreach ($achievements as $ach) {
                $ach->gambar_exists = !empty($ach->gambar) && file_exists(public_path($ach->gambar));
            }
        }

        return view('ortu.dashboard', compact('ortu', 'siswa', 'stats', 'upcomingJadwal', 'recentAgenda', 'achievements'));
    }

    public function anak()
    {
        list($ortu, $siswa) = $this->getOrtuAndSiswa();
        if (!$siswa) {
            return redirect()->route('ortu.dashboard')->with('error', 'Data anak belum terdaftar.');
        }
        return view('ortu.anak', compact('ortu', 'siswa'));
    }

    public function kelompokKelas()
    {
        list($ortu, $siswa) = $this->getOrtuAndSiswa();
        $kelompok = $siswa ? $siswa->kelompokKelas : null;
        if ($kelompok) {
            $kelompok->banner_exists = !empty($kelompok->upload_kelompok_kelas) && file_exists(public_path($kelompok->upload_kelompok_kelas));
        }
        return view('ortu.kelompok-kelas', compact('ortu', 'siswa', 'kelompok'));
    }

    public function jadwal()
    {
        list($ortu, $siswa) = $this->getOrtuAndSiswa();
        $jadwals = [];
        if ($siswa) {
            $jadwals = JadwalLatihan::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
                ->orderBy('tanggal', 'asc')
                ->get();
        }
        return view('ortu.jadwal', compact('ortu', 'siswa', 'jadwals'));
    }

    public function agenda()
    {
        list($ortu, $siswa) = $this->getOrtuAndSiswa();
        $agendas = [];
        if ($siswa) {
            $agendas = Agenda::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
                ->orderBy('tanggal', 'asc')
                ->get();
        }
        return view('ortu.agenda', compact('ortu', 'siswa', 'agendas'));
    }

    public function tournament()
    {
        list($ortu, $siswa) = $this->getOrtuAndSiswa();
        $tournaments = [];
        if ($siswa) {
            $tournaments = Tournament::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
                ->orderBy('tanggal', 'asc')
                ->get();
        }
        return view('ortu.tournament', compact('ortu', 'siswa', 'tournaments'));
    }

    public function achievement()
    {
        list($ortu, $siswa) = $this->getOrtuAndSiswa();
        $achievements = [];
        if ($siswa) {
            $achievements = Achievement::where('id_kelompok_kelas', $siswa->id_kelompok_kelas)
                ->orderBy('id', 'desc')
                ->get();
            foreach ($achievements as $ach) {
                $ach->gambar_exists = !empty($ach->gambar) && file_exists(public_path($ach->gambar));
            }
        }
        return view('ortu.achievement', compact('ortu', 'siswa', 'achievements'));
    }
}