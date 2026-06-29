<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function create()
    {
        $kelompokKelas = DB::table('kelompok_kelas')->get();
        $stats = $this->getPortalStats();
        return view('auth.register', compact('kelompokKelas', 'stats'));
    }

    public function createBeasiswa()
    {
        $kelompokKelas = DB::table('kelompok_kelas')->get();
        $jenisBeasiswa = DB::table('jenis_beasiswa')->get();
        $stats = $this->getPortalStats();
        return view('auth.register-beasiswa', compact('kelompokKelas', 'jenisBeasiswa', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'       => 'required|string|max:255',
            'tempat_lahir'       => 'required|string|max:255',
            'tanggal_lahir'      => 'required|date',
            'jenis_kelamin'      => 'required|in:L,P',
            'alamat'             => 'required|string',
            'nomor_hp'           => 'required|string|max:30',
            'asal_sekolah'       => 'required|string|max:255',
            'id_kelompok_kelas'  => 'required|integer|exists:kelompok_kelas,id',
            'nama_ayah'          => 'required|string|max:255',
            'pekerjaan_ayah'     => 'required|string|max:255',
            'nomor_hp_ayah'      => 'required|string|max:30',
            'nama_ibu'           => 'required|string|max:255',
            'pekerjaan_ibu'      => 'required|string|max:255',
            'nomor_hp_ibu'       => 'required|string|max:30',
            'email_ortu'         => 'required|email|max:255|unique:daftar_reguler,email_ortu|unique:users,email',
            'password_ortu'      => 'required|string|min:8|confirmed',
            'email_siswa'        => 'required|email|max:255|different:email_ortu|unique:daftar_reguler,email_siswa|unique:users,email',
            'password_siswa'     => 'required|string|min:8|confirmed',
        ]);

        $nextId = (DB::table('daftar_reguler')->max('id') ?? 0) + 1;

        $kodePendaftaran =
            'REG' .
            date('y') .
            str_pad($nextId, 4, '0', STR_PAD_LEFT);

        DB::table('daftar_reguler')->insert([
            'kode_pendaftaran' => $kodePendaftaran,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'nomor_hp' => $request->nomor_hp,
            'asal_sekolah' => $request->asal_sekolah,
            'id_kelompok_kelas' => $request->id_kelompok_kelas,
            'email' => $request->email_ortu,
            'email_ortu' => $request->email_ortu,
            'password_ortu' => \Illuminate\Support\Facades\Hash::make($request->password_ortu),
            'email_siswa' => $request->email_siswa,
            'password_siswa' => \Illuminate\Support\Facades\Hash::make($request->password_siswa),
            'nama_ayah' => $request->nama_ayah,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'nomor_hp_ayah' => $request->nomor_hp_ayah,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'nomor_hp_ibu' => $request->nomor_hp_ibu,
            'upload_akte' => null,
            'upload_kk' => null,
            'status_pendaftaran' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('register.success')
            ->with('kode_pendaftaran', $kodePendaftaran);
    }

    public function storeBeasiswa(Request $request)
    {
        $request->validate([
            'nama_lengkap'       => 'required|string|max:255',
            'tempat_lahir'       => 'required|string|max:255',
            'tanggal_lahir'      => 'required|date',
            'jenis_kelamin'      => 'required|in:L,P',
            'alamat'             => 'required|string',
            'nomor_hp'           => 'required|string|max:30',
            'asal_sekolah'       => 'required|string|max:255',
            'id_kelompok_kelas'  => 'required|integer|exists:kelompok_kelas,id',
            'nama_ayah'          => 'required|string|max:255',
            'pekerjaan_ayah'     => 'required|string|max:255',
            'nomor_hp_ayah'      => 'required|string|max:30',
            'nama_ibu'           => 'required|string|max:255',
            'pekerjaan_ibu'      => 'required|string|max:255',
            'nomor_hp_ibu'       => 'required|string|max:30',
            'email_ortu'         => 'required|email|max:255|unique:daftar_beasiswa,email_ortu|unique:users,email',
            'password_ortu'      => 'required|string|min:8|confirmed',
            'email_siswa'        => 'required|email|max:255|different:email_ortu|unique:daftar_beasiswa,email_siswa|unique:users,email',
            'password_siswa'     => 'required|string|min:8|confirmed',
            'id_jenis_beasiswa'  => 'required|integer|exists:jenis_beasiswa,id',
            'sertifikat_1'       => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'sertifikat_2'       => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'sertifikat_3'       => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'video'              => 'nullable|file|mimes:mp4,mov,avi,webm,mkv|max:20480',
        ]);

        $nextId = (DB::table('daftar_beasiswa')->max('id') ?? 0) + 1;
        $kodePendaftaran = 'BEA' . date('Y') . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $sertifikat1 = $request->hasFile('sertifikat_1') ? $this->uploadRegistrationFile($request->file('sertifikat_1'), 'documents') : null;
        $sertifikat2 = $request->hasFile('sertifikat_2') ? $this->uploadRegistrationFile($request->file('sertifikat_2'), 'documents') : null;
        $sertifikat3 = $request->hasFile('sertifikat_3') ? $this->uploadRegistrationFile($request->file('sertifikat_3'), 'documents') : null;
        $video = $request->hasFile('video') ? $this->uploadRegistrationFile($request->file('video'), 'videos') : null;

        DB::table('daftar_beasiswa')->insert([
            'id_jenis_beasiswa' => $request->id_jenis_beasiswa,
            'kode_pendaftaran' => $kodePendaftaran,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'nomor_hp' => $request->nomor_hp,
            'asal_sekolah' => $request->asal_sekolah,
            'id_kelompok_kelas' => $request->id_kelompok_kelas,
            'nama_ayah' => $request->nama_ayah,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'nomor_hp_ayah' => $request->nomor_hp_ayah,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'nomor_hp_ibu' => $request->nomor_hp_ibu,
            'email_ortu' => $request->email_ortu,
            'password_ortu' => \Illuminate\Support\Facades\Hash::make($request->password_ortu),
            'email_siswa' => $request->email_siswa,
            'password_siswa' => \Illuminate\Support\Facades\Hash::make($request->password_siswa),
            'email' => $request->email_ortu,
            'sertifikat_1' => $sertifikat1,
            'sertifikat_2' => $sertifikat2,
            'sertifikat_3' => $sertifikat3,
            'video' => $video,
            'status_pendaftaran' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('register.beasiswa.success')
            ->with('kode_pendaftaran', $kodePendaftaran);
    }

    private function uploadRegistrationFile($file, $category)
    {
        $directory = 'uploads/admin/daftar-beasiswa/' . $category;
        $targetDirectory = public_path($directory);
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        $filename = now()->format('YmdHis') . '-' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($targetDirectory, $filename);
        return $directory . '/' . $filename;
    }

    public function checkStatusForm()
    {
        return view('auth.check-status');
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'kode_pendaftaran' => 'required|string',
            'email' => 'required|email',
        ]);

        // Search in daftar_beasiswa first
        $data = DB::table('daftar_beasiswa')
            ->where('kode_pendaftaran', $request->kode_pendaftaran)
            ->where(function($query) use ($request) {
                $query->where('email', $request->email)
                      ->orWhere('email_ortu', $request->email);
            })
            ->first();

        if ($data) {
            $data->is_beasiswa = true;
        } else {
            // Fallback to searching daftar_reguler
            $data = DB::table('daftar_reguler')
                ->where('kode_pendaftaran', $request->kode_pendaftaran)
                ->where(function($query) use ($request) {
                    $query->where('email', $request->email)
                          ->orWhere('email_ortu', $request->email);
                })
                ->first();
        }

        // If data exists, eager load the kelompok_kelas name to show in UI
        if ($data) {
            $kelompok = DB::table('kelompok_kelas')->where('id', $data->id_kelompok_kelas)->first();
            $data->kelompok_kelas_label = $kelompok ? trim($kelompok->nama_kelompok . ' (' . $kelompok->dari_tahun_kelahiran . ' - ' . $kelompok->sampai_tahun_kelahiran . ')') : '-';
            
            if (isset($data->id_jenis_beasiswa)) {
                $beasiswa = DB::table('jenis_beasiswa')->where('id', $data->id_jenis_beasiswa)->first();
                $data->jenis_beasiswa_label = $beasiswa ? $beasiswa->nama_beasiswa : '-';
            }
        }

        return view('auth.check-status', [
            'data' => $data,
            'searched' => true,
        ]);
    }
}