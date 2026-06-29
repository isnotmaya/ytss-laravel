<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SiswaProfileController extends Controller
{
    public function index()
    {
        $siswa = Siswa::where(
            'kd_users',
            Auth::user()->kd_users
        )->firstOrFail();

        $completionFields = [
            'upload_foto' => $siswa->upload_foto,
            'upload_akte' => $siswa->upload_akte,
            'upload_kk' => $siswa->upload_kk,
            'upload_ijazah' => $siswa->upload_ijazah,
            'upload_nisn' => $siswa->upload_nisn,
        ];

        $completedCount = 0;
        foreach ($completionFields as $val) {
            if (!empty($val)) {
                $completedCount++;
            }
        }
        $completionPercentage = round(($completedCount / count($completionFields)) * 100);

        // Determine if the student registered via the scholarship (beasiswa) path
        $parentEmail = null;
        if ($siswa->ortu && $siswa->ortu->user) {
            $parentEmail = $siswa->ortu->user->email;
        }

        $isBeasiswa = \DB::table('daftar_beasiswa')
            ->where('status_pendaftaran', 'diterima')
            ->where(function($query) use ($parentEmail, $siswa) {
                $query->where('email_siswa', Auth::user()->email)
                      ->orWhere('email', Auth::user()->email);
                
                if ($parentEmail) {
                    $query->orWhere('email_ortu', $parentEmail)
                          ->orWhere('email', $parentEmail);
                }

                $rawBirthDate = $siswa->getRawOriginal('tanggal_lahir');
                if (!empty($siswa->nama_lengkap) && !empty($rawBirthDate) && $rawBirthDate !== '0000-00-00') {
                    $query->orWhere(function($sub) use ($siswa, $rawBirthDate) {
                        $sub->where('nama_lengkap', $siswa->nama_lengkap)
                            ->where('tanggal_lahir', $rawBirthDate);
                    });
                }
            })
            ->exists();

        return view('siswa.profile', compact('siswa', 'completionPercentage', 'completionFields', 'isBeasiswa'));
    }

    public function updateProfile(Request $request)
    {
        $siswa = Siswa::where(
            'kd_users',
            Auth::user()->kd_users
        )->firstOrFail();

        // Determine if the student registered via the scholarship (beasiswa) path
        $parentEmail = null;
        if ($siswa->ortu && $siswa->ortu->user) {
            $parentEmail = $siswa->ortu->user->email;
        }

        $isBeasiswa = \DB::table('daftar_beasiswa')
            ->where('status_pendaftaran', 'diterima')
            ->where(function($query) use ($parentEmail, $siswa) {
                $query->where('email_siswa', Auth::user()->email)
                      ->orWhere('email', Auth::user()->email);
                
                if ($parentEmail) {
                    $query->orWhere('email_ortu', $parentEmail)
                          ->orWhere('email', $parentEmail);
                }

                $rawBirthDate = $siswa->getRawOriginal('tanggal_lahir');
                if (!empty($siswa->nama_lengkap) && !empty($rawBirthDate) && $rawBirthDate !== '0000-00-00') {
                    $query->orWhere(function($sub) use ($siswa, $rawBirthDate) {
                        $sub->where('nama_lengkap', $siswa->nama_lengkap)
                            ->where('tanggal_lahir', $rawBirthDate);
                    });
                }
            })
            ->exists();

        $rules = [
            'nomor_hp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
            'asal_sekolah' => 'nullable|string|max:255',
            'upload_foto' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'upload_akte' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'upload_kk' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'upload_ijazah' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'upload_nisn' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ];

        if ($isBeasiswa) {
            $rules['beasiswa_sertifikat_1'] = 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120';
            $rules['beasiswa_sertifikat_2'] = 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120';
            $rules['beasiswa_sertifikat_3'] = 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120';
            $rules['beasiswa_video'] = 'nullable|file|mimes:mp4,mov,avi,webm,mkv|max:20480';
        }

        $request->validate($rules);

        if ($request->hasFile('upload_foto')) {
            $this->deleteOldSiswaFile($siswa->upload_foto);
            $siswa->upload_foto = $this->storeSiswaFile($request->file('upload_foto'));
        }

        if ($request->hasFile('upload_akte')) {
            $this->deleteOldSiswaFile($siswa->upload_akte);
            $siswa->upload_akte = $this->storeSiswaFile($request->file('upload_akte'));
        }

        if ($request->hasFile('upload_kk')) {
            $this->deleteOldSiswaFile($siswa->upload_kk);
            $siswa->upload_kk = $this->storeSiswaFile($request->file('upload_kk'));
        }

        if ($request->hasFile('upload_ijazah')) {
            $this->deleteOldSiswaFile($siswa->upload_ijazah);
            $siswa->upload_ijazah = $this->storeSiswaFile($request->file('upload_ijazah'));
        }

        if ($request->hasFile('upload_nisn')) {
            $this->deleteOldSiswaFile($siswa->upload_nisn);
            $siswa->upload_nisn = $this->storeSiswaFile($request->file('upload_nisn'));
        }

        if ($isBeasiswa) {
            if ($request->hasFile('beasiswa_sertifikat_1')) {
                $this->deleteOldSiswaFile($siswa->beasiswa_sertifikat_1);
                $siswa->beasiswa_sertifikat_1 = $this->storeSiswaFile($request->file('beasiswa_sertifikat_1'));
            }

            if ($request->hasFile('beasiswa_sertifikat_2')) {
                $this->deleteOldSiswaFile($siswa->beasiswa_sertifikat_2);
                $siswa->beasiswa_sertifikat_2 = $this->storeSiswaFile($request->file('beasiswa_sertifikat_2'));
            }

            if ($request->hasFile('beasiswa_sertifikat_3')) {
                $this->deleteOldSiswaFile($siswa->beasiswa_sertifikat_3);
                $siswa->beasiswa_sertifikat_3 = $this->storeSiswaFile($request->file('beasiswa_sertifikat_3'));
            }

            if ($request->hasFile('beasiswa_video')) {
                $this->deleteOldSiswaFile($siswa->beasiswa_video);
                $siswa->beasiswa_video = $this->storeSiswaFile($request->file('beasiswa_video'));
            }
        }

        $siswa->nomor_hp = $request->nomor_hp;
        $siswa->alamat = $request->alamat;
        $siswa->asal_sekolah = $request->asal_sekolah;

        $siswa->save();

        return back()->with(
            'success',
            'Profil berhasil diperbarui'
        );
    }

    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->email = $request->email;

        if ($request->filled('password')) {

            $user->password = Hash::make(
                $request->password
            );
        }

        $user->save();

        return back()->with(
            'success',
            'Akun berhasil diperbarui'
        );
    } // kode update akun

    private function storeSiswaFile($file)
    {
        $directory = 'uploads/siswa';
        $targetDirectory = public_path($directory);
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        $filename = now()->format('YmdHis') . '-' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($targetDirectory, $filename);
        return $directory . '/' . $filename;
    }

    private function deleteOldSiswaFile(?string $path)
    {
        if (empty($path)) {
            return;
        }

        // Prevent directory traversal
        if (strpos($path, '..') !== false) {
            return;
        }

        // Enforce that Siswa can only delete files under uploads/siswa/
        $normalizedPath = str_replace('\\', '/', trim($path, '/'));
        if (strpos($normalizedPath, 'uploads/siswa/') !== 0) {
            return;
        }

        $absolutePath = public_path($normalizedPath);
        if (file_exists($absolutePath)) {
            @unlink($absolutePath);
        }
    }
}
