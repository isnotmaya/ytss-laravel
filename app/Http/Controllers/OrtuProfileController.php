<?php

namespace App\Http\Controllers;

use App\Models\SiswaOrtu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OrtuProfileController extends Controller
{
    private function getOrtuAndSiswa()
    {
        $ortu = SiswaOrtu::with(['user', 'siswa.kelompokKelas'])
            ->where('kd_users', Auth::user()->kd_users)
            ->first();

        $siswa = $ortu ? $ortu->siswa : null;

        return [$ortu, $siswa];
    }

    public function profile()
    {
        list($ortu, $siswa) = $this->getOrtuAndSiswa();
        return view('ortu.profile', compact('ortu', 'siswa'));
    }

    public function updateProfile(Request $request)
    {
        list($ortu, $siswa) = $this->getOrtuAndSiswa();
        if (!$ortu) {
            return back()->with('error', 'Data orang tua tidak ditemukan.');
        }

        $request->validate([
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'nomor_hp_ayah' => 'required|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'nomor_hp_ibu' => 'required|string|max:20',
            'upload_foto' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        if ($request->hasFile('upload_foto')) {
            $this->deleteOldOrtuFile($ortu->upload_foto);
            $ortu->upload_foto = $this->storeOrtuFile($request->file('upload_foto'));
        }

        $ortu->fill($request->only([
            'nama_ayah',
            'pekerjaan_ayah',
            'nomor_hp_ayah',
            'nama_ibu',
            'pekerjaan_ibu',
            'nomor_hp_ibu',
        ]));

        $ortu->save();

        return back()->with('success', 'Profil orang tua berhasil diperbarui.');
    }

    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Akun login berhasil diperbarui.');
    }

    private function storeOrtuFile($file)
    {
        $directory = 'uploads/ortu';
        $targetDirectory = public_path($directory);
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
        $filename = now()->format('YmdHis') . '-' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($targetDirectory, $filename);
        return $directory . '/' . $filename;
    }

    private function deleteOldOrtuFile(?string $path)
    {
        if (empty($path)) {
            return;
        }

        // Prevent directory traversal
        if (strpos($path, '..') !== false) {
            return;
        }

        // Enforce that Ortu can only delete files under uploads/ortu/
        $normalizedPath = str_replace('\\', '/', trim($path, '/'));
        if (strpos($normalizedPath, 'uploads/ortu/') !== 0) {
            return;
        }

        $absolutePath = public_path($normalizedPath);
        if (file_exists($absolutePath)) {
            @unlink($absolutePath);
        }
    }
}
