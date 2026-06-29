<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminInputController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->query('section', session('activeForm', 'profil-sekolah'));
        $editingEntity = $request->query('edit_entity', session('editingEntity'));
        $editingId = $request->query('edit_id', session('editingId'));

        return view('admin.forms', [
            'kelompokKelas' => $this->tableRows('kelompok_kelas', 'nama_kelompok'),
            'jenisBeasiswa' => $this->tableRows('jenis_beasiswa', 'nama_beasiswa'),
            'siswaList' => $this->tableRows('siswa', 'nama_lengkap'),
            'activeForm' => $section,
            'editing' => [
                'entity' => $editingEntity,
                'id' => $editingId,
                'record' => $this->findRecordByEntity($editingEntity, $editingId),
            ],
            'entityTables' => $this->entityTables(),
        ]);
    }

    public function store(Request $request, string $entity): RedirectResponse
    {
        return $this->persistEntity($request, $entity);
    }

    public function update(Request $request, string $entity, int $id): RedirectResponse
    {
        return $this->persistEntity($request, $entity, $id);
    }

    public function destroy(string $entity, int $id): RedirectResponse
    {
        $config = $this->entityConfig($entity);
        $table = $config['table'];

        if (!$this->tableExists($table)) {
            abort(404);
        }

        $record = DB::table($table)->where('id', $id)->first();

        if (!$record) {
            abort(404);
        }

        $this->deleteUploadedFiles($entity, $record);

        DB::table($table)->where('id', $id)->delete();

        return redirect()
            ->to(route('admin.forms.index') . '?section=' . $entity . '#' . $entity)
            ->with('success', $config['delete_message'])
            ->with('activeForm', $entity);
    }

    public function approveDaftarReguler(int $id): RedirectResponse
    {
        $daftar = DB::table('daftar_reguler')->where('id', $id)->first();

        if (!$daftar) {
            abort(404);
        }

        // Validasi Duplikasi Approve
        if ($daftar->status_pendaftaran !== 'pending') {
            return back()->with('error', 'Pendaftaran ini sudah diproses sebelumnya.');
        }

        // Start Transaction
        DB::beginTransaction();
        try {
            // Generate User Orang Tua Logic
            $parentEmail = $daftar->email_ortu ?? $daftar->email;
            $existingUser = DB::table('users')->where('email', $parentEmail)->first();
            if ($existingUser) {
                if ($existingUser->role === 'ortu') {
                    $kdUsersOrtu = $existingUser->kd_users;
                    // Update relevant data
                    DB::table('users')->where('id', $existingUser->id)->update([
                        'name' => $daftar->nama_ayah,
                        'updated_at' => now(),
                    ]);
                } else {
                    DB::rollBack();
                    return back()->with('error', 'Email orang tua sudah terdaftar dengan role ' . $existingUser->role);
                }
            } else {
                $maxOrtu = DB::table('users')->where('kd_users', 'like', 'ORT%')->max('kd_users');
                $nextOrtuNum = 1;
                if ($maxOrtu) {
                    $nextOrtuNum = ((int) substr($maxOrtu, 3)) + 1;
                }
                $kdUsersOrtu = 'ORT' . str_pad($nextOrtuNum, 3, '0', STR_PAD_LEFT);

                $parentPassword = !empty($daftar->password_ortu) ? $daftar->password_ortu : Hash::make($daftar->nomor_hp_ayah ? str_replace(' ', '', $daftar->nomor_hp_ayah) : 'ytss123');

                DB::table('users')->insert([
                    'kd_users' => $kdUsersOrtu,
                    'name' => $daftar->nama_ayah,
                    'email' => $parentEmail,
                    'role' => 'ortu',
                    'status_aktif' => true,
                    'password' => $parentPassword,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Generate User Siswa Logic
            $siswaEmail = $daftar->email_siswa ?? (strtolower($daftar->kode_pendaftaran) . '.siswa@ytss.com');
            $existingSiswaUser = DB::table('users')->where('email', $siswaEmail)->first();
            if ($existingSiswaUser) {
                if ($existingSiswaUser->role === 'siswa') {
                    $kdUsersSiswa = $existingSiswaUser->kd_users;
                    // Update relevant data
                    DB::table('users')->where('id', $existingSiswaUser->id)->update([
                        'name' => $daftar->nama_lengkap,
                        'updated_at' => now(),
                    ]);
                } else {
                    DB::rollBack();
                    return back()->with('error', 'Email siswa (' . $siswaEmail . ') sudah terdaftar dengan role ' . $existingSiswaUser->role);
                }
            } else {
                $maxSiswa = DB::table('users')->where('kd_users', 'like', 'SIS%')->max('kd_users');
                $nextSiswaNum = 1;
                if ($maxSiswa) {
                    $nextSiswaNum = ((int) substr($maxSiswa, 3)) + 1;
                }
                $kdUsersSiswa = 'SIS' . str_pad($nextSiswaNum, 3, '0', STR_PAD_LEFT);

                $siswaPassword = !empty($daftar->password_siswa) ? $daftar->password_siswa : Hash::make('ytss123');

                DB::table('users')->insert([
                    'kd_users' => $kdUsersSiswa,
                    'name' => $daftar->nama_lengkap,
                    'email' => $siswaEmail,
                    'role' => 'siswa',
                    'status_aktif' => true,
                    'password' => $siswaPassword,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Generate Data Siswa Logic
            $existingSiswa = DB::table('siswa')->where('kd_users', $kdUsersSiswa)->first();
            
            $siswaData = [
                'id_kelompok_kelas' => $daftar->id_kelompok_kelas,
                'nama_lengkap' => $daftar->nama_lengkap,
                'tempat_lahir' => $daftar->tempat_lahir,
                'tanggal_lahir' => $daftar->tanggal_lahir,
                'jenis_kelamin' => $daftar->jenis_kelamin,
                'alamat' => $daftar->alamat,
                'nomor_hp' => $daftar->nomor_hp,
                'asal_sekolah' => $daftar->asal_sekolah,
                'upload_akte' => $daftar->upload_akte,
                'upload_kk' => $daftar->upload_kk,
                'status_aktif' => 'aktif',
                'updated_at' => now(),
            ];

            if (Schema::hasColumn('siswa', 'nis')) {
                $siswaData['nis'] = null;
            }

            if ($existingSiswa) {
                $siswaId = $existingSiswa->id;
                DB::table('siswa')->where('id', $siswaId)->update($siswaData);
            } else {
                $siswaData['kd_users'] = $kdUsersSiswa;
                $siswaData['created_at'] = now();
                $siswaId = DB::table('siswa')->insertGetId($siswaData);
            }

            // Generate Data Orang Tua Logic
            $existingSiswaOrtu = DB::table('siswa_ortu')
                ->where('id_siswa', $siswaId)
                ->where('kd_users', $kdUsersOrtu)
                ->first();

            $ortuData = [
                'nama_ayah' => $daftar->nama_ayah,
                'pekerjaan_ayah' => $daftar->pekerjaan_ayah,
                'nomor_hp_ayah' => $daftar->nomor_hp_ayah,
                'nama_ibu' => $daftar->nama_ibu,
                'pekerjaan_ibu' => $daftar->pekerjaan_ibu,
                'nomor_hp_ibu' => $daftar->nomor_hp_ibu,
                'updated_at' => now(),
            ];

            if ($existingSiswaOrtu) {
                DB::table('siswa_ortu')->where('id', $existingSiswaOrtu->id)->update($ortuData);
            } else {
                $ortuData['id_siswa'] = $siswaId;
                $ortuData['kd_users'] = $kdUsersOrtu;
                $ortuData['created_at'] = now();
                DB::table('siswa_ortu')->insert($ortuData);
            }

            // Update status_pendaftaran to diterima
            $updatePayload = [
                'status_pendaftaran' => 'diterima',
                'updated_at' => now(),
            ];
            // Check if column exists before saving to avoid SQL errors
            if (Schema::hasColumn('daftar_reguler', 'id_siswa')) {
                $updatePayload['id_siswa'] = $siswaId;
            }
            if (Schema::hasColumn('daftar_reguler', 'kd_users_siswa')) {
                $updatePayload['kd_users_siswa'] = $kdUsersSiswa;
            }
            if (Schema::hasColumn('daftar_reguler', 'kd_users_ortu')) {
                $updatePayload['kd_users_ortu'] = $kdUsersOrtu;
            }

            DB::table('daftar_reguler')
                ->where('id', $id)
                ->update($updatePayload);

            DB::commit();

            return redirect()
                ->to(route('admin.forms.index') . '?section=daftar-reguler#daftar-reguler')
                ->with('success', 'Pendaftaran berhasil diterima. Akun Orang Tua & Siswa telah dibuat/diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function rejectDaftarReguler(int $id): RedirectResponse
    {
        $daftar = DB::table('daftar_reguler')->where('id', $id)->first();

        if (!$daftar) {
            abort(404);
        }

        if ($daftar->status_pendaftaran !== 'pending') {
            return back()->with('error', 'Pendaftaran ini sudah diproses sebelumnya.');
        }

        DB::table('daftar_reguler')
            ->where('id', $id)
            ->update([
                'status_pendaftaran' => 'ditolak',
                'updated_at' => now(),
            ]);

        return redirect()
            ->to(route('admin.forms.index') . '?section=daftar-reguler#daftar-reguler')
            ->with('success', 'Pendaftaran berhasil ditolak.');
    }
    

    public function approveDaftarBeasiswa(int $id): RedirectResponse
    {
        $daftar = DB::table('daftar_beasiswa')->where('id', $id)->first();

        if (!$daftar) {
            abort(404);
        }

        if ($daftar->status_pendaftaran !== 'pending') {
            return back()->with('error', 'Pendaftaran ini sudah diproses sebelumnya.');
        }

        // Start Transaction
        DB::beginTransaction();
        try {
            // Generate User Orang Tua Logic
            $parentEmail = $daftar->email_ortu ?? $daftar->email;
            $existingUser = DB::table('users')->where('email', $parentEmail)->first();
            if ($existingUser) {
                if ($existingUser->role === 'ortu') {
                    $kdUsersOrtu = $existingUser->kd_users;
                    // Update relevant data
                    DB::table('users')->where('id', $existingUser->id)->update([
                        'name' => $daftar->nama_ayah,
                        'updated_at' => now(),
                    ]);
                } else {
                    DB::rollBack();
                    return back()->with('error', 'Email orang tua sudah terdaftar dengan role ' . $existingUser->role);
                }
            } else {
                $maxOrtu = DB::table('users')->where('kd_users', 'like', 'ORT%')->max('kd_users');
                $nextOrtuNum = 1;
                if ($maxOrtu) {
                    $nextOrtuNum = ((int) substr($maxOrtu, 3)) + 1;
                }
                $kdUsersOrtu = 'ORT' . str_pad($nextOrtuNum, 3, '0', STR_PAD_LEFT);

                $parentPassword = !empty($daftar->password_ortu) ? $daftar->password_ortu : Hash::make($daftar->nomor_hp_ayah ? str_replace(' ', '', $daftar->nomor_hp_ayah) : 'ytss123');

                DB::table('users')->insert([
                    'kd_users' => $kdUsersOrtu,
                    'name' => $daftar->nama_ayah,
                    'email' => $parentEmail,
                    'role' => 'ortu',
                    'status_aktif' => true,
                    'password' => $parentPassword,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Generate User Siswa Logic
            $siswaEmail = $daftar->email_siswa ?? (strtolower($daftar->kode_pendaftaran) . '.siswa@ytss.com');
            $existingSiswaUser = DB::table('users')->where('email', $siswaEmail)->first();
            if ($existingSiswaUser) {
                if ($existingSiswaUser->role === 'siswa') {
                    $kdUsersSiswa = $existingSiswaUser->kd_users;
                    // Update relevant data
                    DB::table('users')->where('id', $existingSiswaUser->id)->update([
                        'name' => $daftar->nama_lengkap,
                        'updated_at' => now(),
                    ]);
                } else {
                    DB::rollBack();
                    return back()->with('error', 'Email siswa (' . $siswaEmail . ') sudah terdaftar dengan role ' . $existingSiswaUser->role);
                }
            } else {
                $maxSiswa = DB::table('users')->where('kd_users', 'like', 'SIS%')->max('kd_users');
                $nextSiswaNum = 1;
                if ($maxSiswa) {
                    $nextSiswaNum = ((int) substr($maxSiswa, 3)) + 1;
                }
                $kdUsersSiswa = 'SIS' . str_pad($nextSiswaNum, 3, '0', STR_PAD_LEFT);

                $siswaPassword = !empty($daftar->password_siswa) ? $daftar->password_siswa : Hash::make('ytss123');

                DB::table('users')->insert([
                    'kd_users' => $kdUsersSiswa,
                    'name' => $daftar->nama_lengkap,
                    'email' => $siswaEmail,
                    'role' => 'siswa',
                    'status_aktif' => true,
                    'password' => $siswaPassword,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Generate Data Siswa Logic
            $existingSiswa = DB::table('siswa')->where('kd_users', $kdUsersSiswa)->first();
            
            $siswaData = [
                'id_kelompok_kelas' => $daftar->id_kelompok_kelas,
                'nama_lengkap' => $daftar->nama_lengkap,
                'tempat_lahir' => $daftar->tempat_lahir,
                'tanggal_lahir' => $daftar->tanggal_lahir,
                'jenis_kelamin' => $daftar->jenis_kelamin,
                'alamat' => $daftar->alamat,
                'nomor_hp' => $daftar->nomor_hp,
                'asal_sekolah' => $daftar->asal_sekolah,
                'status_aktif' => 'aktif',
                'beasiswa_sertifikat_1' => $daftar->sertifikat_1,
                'beasiswa_sertifikat_2' => $daftar->sertifikat_2,
                'beasiswa_sertifikat_3' => $daftar->sertifikat_3,
                'beasiswa_video' => $daftar->video,
                'updated_at' => now(),
            ];

            if (Schema::hasColumn('siswa', 'nis')) {
                $siswaData['nis'] = null;
            }

            if ($existingSiswa) {
                $siswaId = $existingSiswa->id;
                DB::table('siswa')->where('id', $siswaId)->update($siswaData);
            } else {
                $siswaData['kd_users'] = $kdUsersSiswa;
                $siswaData['created_at'] = now();
                $siswaId = DB::table('siswa')->insertGetId($siswaData);
            }

            // Generate Data Orang Tua Logic
            $existingSiswaOrtu = DB::table('siswa_ortu')
                ->where('id_siswa', $siswaId)
                ->where('kd_users', $kdUsersOrtu)
                ->first();

            $ortuData = [
                'nama_ayah' => $daftar->nama_ayah,
                'pekerjaan_ayah' => $daftar->pekerjaan_ayah,
                'nomor_hp_ayah' => $daftar->nomor_hp_ayah,
                'nama_ibu' => $daftar->nama_ibu,
                'pekerjaan_ibu' => $daftar->pekerjaan_ibu,
                'nomor_hp_ibu' => $daftar->nomor_hp_ibu,
                'updated_at' => now(),
            ];

            if ($existingSiswaOrtu) {
                DB::table('siswa_ortu')->where('id', $existingSiswaOrtu->id)->update($ortuData);
            } else {
                $ortuData['id_siswa'] = $siswaId;
                $ortuData['kd_users'] = $kdUsersOrtu;
                $ortuData['created_at'] = now();
                DB::table('siswa_ortu')->insert($ortuData);
            }

            // Update status_pendaftaran to diterima
            $updatePayload = [
                'status_pendaftaran' => 'diterima',
                'updated_at' => now(),
            ];
            if (Schema::hasColumn('daftar_beasiswa', 'id_siswa')) {
                $updatePayload['id_siswa'] = $siswaId;
            }
            if (Schema::hasColumn('daftar_beasiswa', 'kd_users_siswa')) {
                $updatePayload['kd_users_siswa'] = $kdUsersSiswa;
            }
            if (Schema::hasColumn('daftar_beasiswa', 'kd_users_ortu')) {
                $updatePayload['kd_users_ortu'] = $kdUsersOrtu;
            }

            DB::table('daftar_beasiswa')
                ->where('id', $id)
                ->update($updatePayload);

            DB::commit();

            return redirect()
                ->to(route('admin.forms.index') . '?section=daftar-beasiswa#daftar-beasiswa')
                ->with('success', 'Pendaftaran beasiswa berhasil diterima. Akun Orang Tua & Siswa telah dibuat/diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function rejectDaftarBeasiswa(int $id): RedirectResponse
    {
        $daftar = DB::table('daftar_beasiswa')->where('id', $id)->first();

        if (!$daftar) {
            abort(404);
        }

        if ($daftar->status_pendaftaran !== 'pending') {
            return back()->with('error', 'Pendaftaran ini sudah diproses sebelumnya.');
        }

        DB::table('daftar_beasiswa')
            ->where('id', $id)
            ->update([
                'status_pendaftaran' => 'ditolak',
                'updated_at' => now(),
            ]);

        return redirect()
            ->to(route('admin.forms.index') . '?section=daftar-beasiswa#daftar-beasiswa')
            ->with('success', 'Pendaftaran beasiswa berhasil ditolak.');
    }

    protected function persistEntity(Request $request, string $entity, ?int $id = null): RedirectResponse
    {
        $config = $this->entityConfig($entity);
        $table = $config['table'];

        if (!$this->tableExists($table)) {
            abort(404);
        }

        $existingRecord = $id ? DB::table($table)->where('id', $id)->first() : null;

        if ($id && !$existingRecord) {
            abort(404);
        }

        $rules = $config['rules']($id);
        $validator = Validator::make($request->all(), $rules, $this->validationMessages(), $this->attributeLabels());

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, $entity)
                ->withInput()
                ->with('activeForm', $entity)
                ->with('editingEntity', $id ? $entity : null)
                ->with('editingId', $id);
        }

        $payload = $config['transform'](
            $validator->validated(),
            $request,
            $entity,
            $existingRecord
        );

        if ($id) {
            DB::table($table)
                ->where('id', $id)
                ->update([
                    ...$payload,
                    'updated_at' => now(),
                ]);

            return redirect()
                ->to(route('admin.forms.index') . '?section=' . $entity . '#' . $entity)
                ->with('success', $config['update_message'])
                ->with('activeForm', $entity);
        }

        DB::table($table)->insert([
            ...$payload,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->to(route('admin.forms.index') . '?section=' . $entity . '#' . $entity)
            ->with('success', $config['create_message'])
            ->with('activeForm', $entity);
    }

    protected function entityConfig(string $entity): array
    {
        $configs = [
            'users' => [
                'table' => 'users',
                'create_message' => 'Akun pengguna berhasil ditambahkan.',
                'update_message' => 'Akun pengguna berhasil diperbarui.',
                'delete_message' => 'Akun pengguna berhasil dihapus.',
                'rules' => fn (?int $id = null) => [
                    'kd_users' => ['required', 'string', 'size:6', Rule::unique('users', 'kd_users')->ignore($id)],
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id)],
                    'role' => ['required', Rule::in(['manajemen', 'ortu', 'siswa', 'coach'])],
                    'status_aktif' => ['required', Rule::in(['0', '1'])],
                    'password' => [$id ? 'nullable' : 'required', 'string', 'min:8'],
                ],
                'transform' => function (array $data, Request $request = null, string $entity = null, ?object $record = null) {
                    $payload = [
                        'kd_users' => $data['kd_users'],
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'role' => $data['role'],
                        'status_aktif' => (bool) $data['status_aktif'],
                    ];

                    if (!empty($data['password'])) {
                        $payload['password'] = Hash::make($data['password']);
                    }

                    return $payload;
                },
            ],
            'jenis-beasiswa' => [
                'table' => 'jenis_beasiswa',
                'create_message' => 'Jenis beasiswa berhasil ditambahkan.',
                'update_message' => 'Jenis beasiswa berhasil diperbarui.',
                'delete_message' => 'Jenis beasiswa berhasil dihapus.',
                'rules' => fn (?int $id = null) => [
                    'nama_beasiswa' => ['required', 'string', 'max:255'],
                    'potongan_spp' => ['required', 'integer', 'min:0'],
                    'keterangan' => ['nullable', 'string'],
                ],
                'transform' => fn (array $data, Request $request = null, string $entity = null, ?object $record = null) => $data,
            ],
            'kelompok-kelas' => [
                'table' => 'kelompok_kelas',
                'create_message' => 'Kelompok kelas berhasil ditambahkan.',
                'update_message' => 'Kelompok kelas berhasil diperbarui.',
                'delete_message' => 'Kelompok kelas berhasil dihapus.',
                'rules' => fn (?int $id = null) => [
                    'nama_kelompok' => ['required', 'string', 'max:255'],
                    'dari_tahun_kelahiran' => ['required', 'digits:4'],
                    'sampai_tahun_kelahiran' => ['required', 'digits:4'],
                    'upload_kelompok_kelas' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                    'keterangan_kelompok_kelas' => ['nullable', 'string'],
                ],
                'transform' => fn (array $data, Request $request, string $entity, $record) => [
                    ...$data,
                    ...$this->storeUploadedFiles($request, $entity, ['upload_kelompok_kelas' => 'images'], $record),
                ],
            ],
            'siswa-ortu' => [
                'table' => 'siswa_ortu',
                'create_message' => 'Data orang tua berhasil ditambahkan.',
                'update_message' => 'Data orang tua berhasil diperbarui.',
                'delete_message' => 'Data orang tua berhasil dihapus.',
                'rules' => fn (?int $id = null) => [
                    'id_siswa' => ['nullable', 'integer', 'exists:siswa,id'],
                    'kd_users' => ['nullable', 'string', 'size:6', 'exists:users,kd_users'],
                    'nama_ayah' => ['required', 'string', 'max:255'],
                    'pekerjaan_ayah' => ['nullable', 'string', 'max:255'],
                    'nomor_hp_ayah' => ['required', 'string', 'max:30'],
                    'nama_ibu' => ['required', 'string', 'max:255'],
                    'pekerjaan_ibu' => ['nullable', 'string', 'max:255'],
                    'nomor_hp_ibu' => ['required', 'string', 'max:30'],
                ],
                'transform' => fn (array $data, Request $request = null, string $entity = null, ?object $record = null) => $data,
            ],
            'siswa' => [
                'table' => 'siswa',
                'create_message' => 'Data siswa berhasil ditambahkan.',
                'update_message' => 'Data siswa berhasil diperbarui.',
                'delete_message' => 'Data siswa berhasil dihapus.',
                'rules' => fn (?int $id = null) => [
                    'id_kelompok_kelas' => ['required', 'integer', 'exists:kelompok_kelas,id'],
                    'kd_users' => ['required', 'string', 'size:6', 'exists:users,kd_users', Rule::unique('siswa', 'kd_users')->ignore($id)],
                    'nama_lengkap' => ['required', 'string', 'max:255'],
                    'tempat_lahir' => ['nullable', 'string', 'max:255'],
                    'tanggal_lahir' => ['required', 'date'],
                    'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
                    'alamat' => ['required', 'string'],
                    'nomor_hp' => ['required', 'string', 'max:30'],
                    'asal_sekolah' => ['nullable', 'string', 'max:255'],
                    'upload_akte' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp'],
                    'upload_kk' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp'],
                    'upload_ijazah' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp'],
                    'upload_foto' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                    'status_aktif' => ['required', Rule::in(['daftar-reguler', 'daftar-beasiswa', 'daftar-tolak', 'aktif', 'cuti', 'tidak-aktif'])],
                    'beasiswa_sertifikat_1' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp'],
                    'beasiswa_sertifikat_2' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp'],
                    'beasiswa_sertifikat_3' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp'],
                    'beasiswa_video' => ['nullable', 'file', 'mimes:mp4,mov,avi,webm,mkv'],
                ],
                'transform' => fn (array $data, Request $request, string $entity, $record) => [
                    ...$data,
                    ...$this->storeUploadedFiles($request, $entity, [
                        'upload_akte' => 'documents',
                        'upload_kk' => 'documents',
                        'upload_ijazah' => 'documents',
                        'upload_foto' => 'images',
                        'beasiswa_sertifikat_1' => 'documents',
                        'beasiswa_sertifikat_2' => 'documents',
                        'beasiswa_sertifikat_3' => 'documents',
                        'beasiswa_video' => 'videos',
                    ], $record),
                ],
            ],
            'profil-sekolah' => [
                'table' => 'profil_sekolah',
                'create_message' => 'Profil sekolah berhasil ditambahkan.',
                'update_message' => 'Profil sekolah berhasil diperbarui.',
                'delete_message' => 'Profil sekolah berhasil dihapus.',
                'rules' => fn (?int $id = null) => [
                    'judul_profile_sekolah' => ['required', 'string', 'max:255'],
                    'konten_profile_sekolah' => ['required', 'string'],
                    'upload_photo_profile_sekolah' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                ],
                'transform' => fn (array $data, Request $request, string $entity, $record) => [
                    ...$data,
                    ...$this->storeUploadedFiles($request, $entity, ['upload_photo_profile_sekolah' => 'images'], $record),
                ],
            ],
            'info-promo' => [
                'table' => 'info_promo',
                'create_message' => 'Info promo berhasil ditambahkan.',
                'update_message' => 'Info promo berhasil diperbarui.',
                'delete_message' => 'Info promo berhasil dihapus.',
                'rules' => fn (?int $id = null) => [
                    'judul' => ['required', 'string', 'max:255'],
                    'deskripsi' => ['required', 'string'],
                    'gambar' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                    'tanggal_mulai' => ['required', 'date'],
                    'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
                    'status' => ['required', Rule::in(['0', '1'])],
                ],
                'transform' => fn (array $data, Request $request, string $entity, $record) => [
                    ...$data,
                    ...$this->storeUploadedFiles($request, $entity, ['gambar' => 'images'], $record),
                    'status' => (bool) $data['status'],
                ],
            ],
            'achievement' => [
                'table' => 'achievement',
                'create_message' => 'Data prestasi berhasil ditambahkan.',
                'update_message' => 'Data prestasi berhasil diperbarui.',
                'delete_message' => 'Data prestasi berhasil dihapus.',
                'rules' => fn (?int $id = null) => [
                    'id_kelompok_kelas' => ['required', 'integer', 'exists:kelompok_kelas,id'],
                    'judul' => ['required', 'string', 'max:255'],
                    'deskripsi' => ['nullable', 'string'],
                    'tropi' => ['required', Rule::in(['regional', 'nasional', 'internasional'])],
                    'gambar' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                ],
                'transform' => fn (array $data, Request $request, string $entity, $record) => [
                    ...$data,
                    ...$this->storeUploadedFiles($request, $entity, ['gambar' => 'images'], $record),
                ],
            ],
            'agenda' => $this->scheduleEntityConfig('agenda', 'Agenda'),
            'jadwal-latihan' => $this->scheduleEntityConfig('jadwal_latihan', 'Jadwal latihan'),
            'tournament' => $this->scheduleEntityConfig('tournament', 'Data turnamen'),
            'daftar-reguler' => [
                'table' => 'daftar_reguler',
                'create_message' => 'Pendaftaran reguler berhasil ditambahkan.',
                'update_message' => 'Pendaftaran reguler berhasil diperbarui.',
                'delete_message' => 'Pendaftaran reguler berhasil dihapus.',
                'rules' => fn (?int $id = null) => [
                    'nama_lengkap' => ['required', 'string', 'max:255'],
                    'tempat_lahir' => ['required', 'string', 'max:255'],
                    'tanggal_lahir' => ['required', 'date'],
                    'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
                    'alamat' => ['required', 'string'],
                    'nomor_hp' => ['required', 'string', 'max:30'],
                    'email' => ['required', 'email', 'max:255'],
                    'id_kelompok_kelas' => ['required', 'integer', 'exists:kelompok_kelas,id'],
                    'asal_sekolah' => ['required', 'string', 'max:255'],
                    'nama_ayah' => ['required', 'string', 'max:255'],
                    'pekerjaan_ayah' => ['required', 'string', 'max:255'],
                    'nomor_hp_ayah' => ['required', 'string', 'max:30'],
                    'nama_ibu' => ['required', 'string', 'max:255'],
                    'pekerjaan_ibu' => ['required', 'string', 'max:255'],
                    'nomor_hp_ibu' => ['required', 'string', 'max:30'],
                    'status_pendaftaran' => ['required', Rule::in(['pending', 'diterima', 'ditolak'])],
                    'email_ortu' => ['nullable', 'email', 'max:255'],
                    'password_ortu' => ['nullable', 'string', 'min:8'],
                    'email_siswa' => ['nullable', 'email', 'max:255'],
                    'password_siswa' => ['nullable', 'string', 'min:8'],
                    'upload_akte' => [$id ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
                    'upload_kk' => [$id ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
                ],
                'transform' => function (array $data, Request $request, string $entity, $record) {
                    $files = $this->storeUploadedFiles($request, $entity, [
                        'upload_akte' => 'documents',
                        'upload_kk' => 'documents'
                    ], $record);

                    $payload = array_merge($data, $files);

                    if (!empty($payload['password_ortu'])) {
                        $payload['password_ortu'] = Hash::make($payload['password_ortu']);
                    }
                    if (!empty($payload['password_siswa'])) {
                        $payload['password_siswa'] = Hash::make($payload['password_siswa']);
                    }

                    // Auto-generate code if creating
                    if (!$record && empty($payload['kode_pendaftaran'])) {
                        $nextId = (DB::table('daftar_reguler')->max('id') ?? 0) + 1;
                        $payload['kode_pendaftaran'] = 'REG' . date('y') . str_pad($nextId, 4, '0', STR_PAD_LEFT);
                    }

                    return $payload;
                },
            ],
            'daftar-beasiswa' => [
                'table' => 'daftar_beasiswa',
                'create_message' => 'Pendaftaran beasiswa berhasil ditambahkan.',
                'update_message' => 'Pendaftaran beasiswa berhasil diperbarui.',
                'delete_message' => 'Pendaftaran beasiswa berhasil dihapus.',
                'rules' => fn (?int $id = null) => [
                    'id_jenis_beasiswa' => ['required', 'integer', 'exists:jenis_beasiswa,id'],
                    'id_kelompok_kelas' => ['required', 'integer', 'exists:kelompok_kelas,id'],
                    'nama_lengkap' => ['required', 'string', 'max:255'],
                    'tempat_lahir' => ['required', 'string', 'max:255'],
                    'tanggal_lahir' => ['required', 'date'],
                    'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
                    'alamat' => ['required', 'string'],
                    'nomor_hp' => ['required', 'string', 'max:30'],
                    'asal_sekolah' => ['required', 'string', 'max:255'],
                    'nama_ayah' => ['required', 'string', 'max:255'],
                    'pekerjaan_ayah' => ['required', 'string', 'max:255'],
                    'nomor_hp_ayah' => ['required', 'string', 'max:30'],
                    'nama_ibu' => ['required', 'string', 'max:255'],
                    'pekerjaan_ibu' => ['required', 'string', 'max:255'],
                    'nomor_hp_ibu' => ['required', 'string', 'max:30'],
                    'email_ortu' => ['nullable', 'email', 'max:255'],
                    'password_ortu' => ['nullable', 'string', 'min:8'],
                    'email_siswa' => ['nullable', 'email', 'max:255'],
                    'password_siswa' => ['nullable', 'string', 'min:8'],
                    'email' => ['required', 'email', 'max:255'],
                    'sertifikat_1' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp'],
                    'sertifikat_2' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp'],
                    'sertifikat_3' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp'],
                    'video' => ['nullable', 'file', 'mimes:mp4,mov,avi,webm,mkv'],
                    'status_pendaftaran' => ['required', Rule::in(['pending', 'diterima', 'ditolak'])],
                ],
                'transform' => function (array $data, Request $request, string $entity, $record) {
                    $files = $this->storeUploadedFiles($request, $entity, [
                        'sertifikat_1' => 'documents',
                        'sertifikat_2' => 'documents',
                        'sertifikat_3' => 'documents',
                        'video' => 'videos',
                    ], $record);

                    $payload = array_merge($data, $files);

                    if (!empty($payload['password_ortu'])) {
                        $payload['password_ortu'] = Hash::make($payload['password_ortu']);
                    }
                    if (!empty($payload['password_siswa'])) {
                        $payload['password_siswa'] = Hash::make($payload['password_siswa']);
                    }

                    // Auto-generate code if creating
                    if (!$record && empty($payload['kode_pendaftaran'])) {
                        $nextId = (DB::table('daftar_beasiswa')->max('id') ?? 0) + 1;
                        $payload['kode_pendaftaran'] = 'BEA' . date('Y') . str_pad($nextId, 4, '0', STR_PAD_LEFT);
                    }

                    return $payload;
                },
            ],
        ];

        if (!isset($configs[$entity])) {
            abort(404);
        }

        return $configs[$entity];
    }

    protected function scheduleEntityConfig(string $table, string $label): array
    {
        return [
            'table' => $table,
            'create_message' => $label . ' berhasil ditambahkan.',
            'update_message' => $label . ' berhasil diperbarui.',
            'delete_message' => $label . ' berhasil dihapus.',
            'rules' => fn (?int $id = null) => [
                'id_kelompok_kelas' => ['required', 'integer', 'exists:kelompok_kelas,id'],
                'judul' => ['required', 'string', 'max:255'],
                'tanggal' => ['required', 'date'],
                'jam_mulai' => ['required', 'date_format:H:i'],
                'jam_selesai' => ['required', 'date_format:H:i'],
                'lokasi' => ['required', 'string', 'max:255'],
                'deskripsi' => ['nullable', 'string'],
            ],
            'transform' => fn (array $data, Request $request = null, string $entity = null, ?object $record = null) => $data,
        ];
    }

    protected function entityTables(): array
    {
        return [
            'profil-sekolah' => $this->buildEntityTable(
                'profil_sekolah',
                ['judul_profile_sekolah' => 'Judul'],
                ['konten_profile_sekolah' => 'Konten', 'upload_photo_profile_sekolah' => 'Foto']
            ),
            'info-promo' => $this->buildEntityTable(
                'info_promo',
                ['judul' => 'Judul', 'status_label' => 'Status'],
                ['deskripsi' => 'Deskripsi', 'tanggal_mulai' => 'Mulai', 'tanggal_selesai' => 'Selesai', 'gambar' => 'Gambar']
            ),
            'users' => $this->buildEntityTable(
                'users',
                ['kd_users' => 'Kode', 'name' => 'Nama', 'status_aktif_label' => 'Status'],
                ['email' => 'Email', 'role' => 'Role']
            ),
            'jenis-beasiswa' => $this->buildEntityTable(
                'jenis_beasiswa',
                ['nama_beasiswa' => 'Nama', 'potongan_spp' => 'Potongan SPP'],
                ['keterangan' => 'Keterangan']
            ),
            'kelompok-kelas' => $this->buildEntityTable(
                'kelompok_kelas',
                ['nama_kelompok' => 'Kelompok', 'dari_tahun_kelahiran' => 'Dari', 'sampai_tahun_kelahiran' => 'Sampai'],
                ['keterangan_kelompok_kelas' => 'Keterangan', 'upload_kelompok_kelas' => 'Banner']
            ),
            'siswa-ortu' => $this->buildEntityTable(
                'siswa_ortu',
                ['kd_users' => 'Kode User', 'nama_ayah' => 'Nama Ayah', 'siswa_label' => 'Siswa'],
                ['nomor_hp_ayah' => 'HP Ayah', 'nama_ibu' => 'Nama Ibu', 'nomor_hp_ibu' => 'HP Ibu', 'pekerjaan_ayah' => 'Pekerjaan Ayah', 'pekerjaan_ibu' => 'Pekerjaan Ibu']
            ),
            'siswa' => $this->buildEntityTable(
                'siswa',
                ['kd_users' => 'Kode', 'nama_lengkap' => 'Nama', 'status_aktif_label' => 'Status'],
                ['kelompok_kelas_label' => 'Kelompok', 'jenis_kelamin' => 'JK', 'nomor_hp' => 'HP', 'asal_sekolah' => 'Asal Sekolah', 'tanggal_lahir' => 'Lahir', 'alamat' => 'Alamat', 'upload_foto' => 'Foto']
            ),
            'achievement' => $this->buildEntityTable(
                'achievement',
                ['judul' => 'Judul', 'tropi' => 'Tropi'],
                ['kelompok_kelas_label' => 'Kelompok', 'deskripsi' => 'Deskripsi', 'gambar' => 'Gambar']
            ),
            'agenda' => $this->buildEntityTable(
                'agenda',
                ['judul' => 'Judul', 'tanggal' => 'Tanggal', 'lokasi' => 'Lokasi'],
                ['kelompok_kelas_label' => 'Kelompok', 'jam_mulai' => 'Mulai', 'jam_selesai' => 'Selesai', 'deskripsi' => 'Deskripsi']
            ),
            'jadwal-latihan' => $this->buildEntityTable(
                'jadwal_latihan',
                ['judul' => 'Judul', 'tanggal' => 'Tanggal', 'lokasi' => 'Lokasi'],
                ['kelompok_kelas_label' => 'Kelompok', 'jam_mulai' => 'Mulai', 'jam_selesai' => 'Selesai', 'deskripsi' => 'Deskripsi']
            ),
            'tournament' => $this->buildEntityTable(
                'tournament',
                ['judul' => 'Judul', 'tanggal' => 'Tanggal', 'lokasi' => 'Lokasi'],
                ['kelompok_kelas_label' => 'Kelompok', 'jam_mulai' => 'Mulai', 'jam_selesai' => 'Selesai', 'deskripsi' => 'Deskripsi']
            ),
            'daftar-reguler' => $this->buildEntityTable(
                'daftar_reguler',
                [
                    'kode_pendaftaran' => 'Kode',
                    'nama_lengkap' => 'Nama Siswa',
                    'kelompok_kelas_label' => 'Kelompok',
                    'status_pendaftaran_label' => 'Status'
                ],
                [
                    'tempat_lahir' => 'Tempat Lahir',
                    'tanggal_lahir' => 'Tanggal Lahir',
                    'jenis_kelamin' => 'JK',
                    'alamat' => 'Alamat',
                    'nomor_hp' => 'Nomor HP',
                    'asal_sekolah' => 'Asal Sekolah',
                    'email' => 'Email',
                    'nama_ayah' => 'Nama Ayah',
                    'pekerjaan_ayah' => 'Pekerjaan Ayah',
                    'nomor_hp_ayah' => 'HP Ayah',
                    'nama_ibu' => 'Nama Ibu',
                    'pekerjaan_ibu' => 'Pekerjaan Ibu',
                    'nomor_hp_ibu' => 'HP Ibu',
                    'upload_akte' => 'Akte',
                    'upload_kk' => 'KK'
                ]
            ),
            'daftar-beasiswa' => $this->buildEntityTable(
                'daftar_beasiswa',
                [
                    'kode_pendaftaran' => 'Kode',
                    'nama_lengkap' => 'Nama Siswa',
                    'jenis_beasiswa_label' => 'Beasiswa',
                    'status_pendaftaran_label' => 'Status'
                ],
                [
                    'tempat_lahir' => 'Tempat Lahir',
                    'tanggal_lahir' => 'Tanggal Lahir',
                    'jenis_kelamin' => 'JK',
                    'alamat' => 'Alamat',
                    'nomor_hp' => 'Nomor HP',
                    'asal_sekolah' => 'Asal Sekolah',
                    'email' => 'Email',
                    'nama_ayah' => 'Nama Ayah',
                    'pekerjaan_ayah' => 'Pekerjaan Ayah',
                    'nomor_hp_ayah' => 'HP Ayah',
                    'nama_ibu' => 'Nama Ibu',
                    'pekerjaan_ibu' => 'Pekerjaan Ibu',
                    'nomor_hp_ibu' => 'HP Ibu',
                    'email_ortu' => 'Email Ortu',
                    'email_siswa' => 'Email Siswa',
                    'sertifikat_1' => 'Sertifikat 1',
                    'sertifikat_2' => 'Sertifikat 2',
                    'sertifikat_3' => 'Sertifikat 3',
                    'video' => 'Video'
                ]
            ),
        ];
    }

    protected function buildEntityTable(string $table, array $primaryColumns, array $detailColumns): array
    {
        [$primaryColumns, $detailColumns] = $this->completeTableColumns($table, $primaryColumns, $detailColumns);
        $records = $this->tableRows($table);

        return [
            'table' => $table,
            'hasSoftDelete' => Schema::hasColumn($table, 'deleted_at'),
            'primaryColumns' => $primaryColumns,
            'detailColumns' => $detailColumns,
            'records' => $this->enrichRecords($table, $records),
        ];
    }

    protected function completeTableColumns(string $table, array $primaryColumns, array $detailColumns): array
    {
        if (!$this->tableExists($table)) {
            return [$primaryColumns, $detailColumns];
        }

        $configuredFields = array_keys($primaryColumns + $detailColumns);
        $excludedFields = [
            'id',
            'created_at',
            'updated_at',
            'email_verified_at',
            'deleted_at',
            'password',
            'remember_token',
        ];

        $fieldAliases = [
            'kelompok_kelas_label' => 'id_kelompok_kelas',
            'jenis_beasiswa_label' => 'id_jenis_beasiswa',
            'status_label' => 'status',
            'status_aktif_label' => 'status_aktif',
            'status_pendaftaran_label' => 'status_pendaftaran',
        ];

        foreach ($configuredFields as $field) {
            if (isset($fieldAliases[$field])) {
                $excludedFields[] = $fieldAliases[$field];
            }
        }

        $remainingFields = collect(Schema::getColumnListing($table))
            ->reject(fn (string $field) => in_array($field, [...$configuredFields, ...$excludedFields], true));

        foreach ($remainingFields as $field) {
            $detailColumns[$field] = $this->columnLabel($field);
        }

        return [$primaryColumns, $detailColumns];
    }

    protected function enrichRecords(string $table, Collection $records): Collection
    {
        if ($table === 'siswa') {
            $siswaModels = \App\Models\Siswa::with(['user', 'ortu', 'kelompokKelas'])->get()->keyBy('id');
            return $records->map(function ($record) use ($siswaModels) {
                if ($siswaModels->has($record->id)) {
                    $model = $siswaModels->get($record->id);
                    if ($model->user) {
                        $record->user_name = $model->user->name;
                        $record->user_email = $model->user->email;
                        $record->user_status_aktif = $model->user->status_aktif;
                        $record->user_role = $model->user->role;
                    }
                    if ($model->ortu) {
                        $record->ortu_nama_ayah = $model->ortu->nama_ayah;
                        $record->ortu_pekerjaan_ayah = $model->ortu->pekerjaan_ayah;
                        $record->ortu_nomor_hp_ayah = $model->ortu->nomor_hp_ayah;
                        $record->ortu_nama_ibu = $model->ortu->nama_ibu;
                        $record->ortu_pekerjaan_ibu = $model->ortu->pekerjaan_ibu;
                        $record->ortu_nomor_hp_ibu = $model->ortu->nomor_hp_ibu;
                    }
                    if ($model->kelompokKelas) {
                        $record->kelompok_kelas_label = trim($model->kelompokKelas->nama_kelompok . ' (' . $model->kelompokKelas->dari_tahun_kelahiran . ' - ' . $model->kelompokKelas->sampai_tahun_kelahiran . ')');
                    }
                }
                if (isset($record->status_aktif)) {
                    $record->status_aktif_label = Str::headline(str_replace('-', ' ', (string) $record->status_aktif));
                }
                return $record;
            });
        }

        $kelompokMap = $this->tableExists('kelompok_kelas')
            ? DB::table('kelompok_kelas')->select('id', 'nama_kelompok', 'dari_tahun_kelahiran', 'sampai_tahun_kelahiran')->get()->keyBy('id')
            : collect();

        $beasiswaMap = $this->tableExists('jenis_beasiswa')
            ? DB::table('jenis_beasiswa')->select('id', 'nama_beasiswa')->get()->keyBy('id')
            : collect();

        $siswaMap = $this->tableExists('siswa')
            ? DB::table('siswa')->select('id', 'nama_lengkap')->get()->keyBy('id')
            : collect();

        return $records->map(function ($record) use ($table, $kelompokMap, $beasiswaMap, $siswaMap) {
            if ($table === 'siswa_ortu') {
                if (isset($record->id_siswa) && $siswaMap->has($record->id_siswa)) {
                    $record->siswa_label = $siswaMap->get($record->id_siswa)->nama_lengkap;
                } else {
                    $record->siswa_label = 'Belum terhubung';
                }
            }

            if (in_array($table, ['siswa', 'achievement', 'agenda', 'jadwal_latihan', 'tournament', 'daftar_reguler', 'daftar_beasiswa']) && isset($record->id_kelompok_kelas) && $kelompokMap->has($record->id_kelompok_kelas)) {
                $kelompok = $kelompokMap->get($record->id_kelompok_kelas);
                $record->kelompok_kelas_label = trim($kelompok->nama_kelompok . ' (' . $kelompok->dari_tahun_kelahiran . ' - ' . $kelompok->sampai_tahun_kelahiran . ')');
            }

            if ($table === 'daftar_beasiswa' && isset($record->id_jenis_beasiswa) && $beasiswaMap->has($record->id_jenis_beasiswa)) {
                $record->jenis_beasiswa_label = $beasiswaMap->get($record->id_jenis_beasiswa)->nama_beasiswa;
            }

            if ($table === 'info_promo') {
                $record->status_label = (string) ($record->status ? 'Aktif' : 'Nonaktif');
            }

            if ($table === 'users') {
                $record->status_aktif_label = (string) ($record->status_aktif ? 'Aktif' : 'Nonaktif');
            }

            if ($table === 'siswa' && isset($record->status_aktif)) {
                $record->status_aktif_label = Str::headline(str_replace('-', ' ', (string) $record->status_aktif));
            }

            if ($table === 'daftar_reguler' || $table === 'daftar_beasiswa') {
                $record->status_pendaftaran_label = ucfirst((string) $record->status_pendaftaran);
            }

            return $record;
        });
    }

    protected function findRecordByEntity(?string $entity, $id): ?object
    {
        if (!$entity || !$id) {
            return null;
        }

        $config = $this->entityConfig($entity);
        $table = $config['table'];

        if (!$this->tableExists($table)) {
            return null;
        }

        return DB::table($table)->where('id', $id)->first();
    }

    protected function tableRows(string $table, ?string $orderBy = null, ?int $limit = null): Collection
    {
        if (!$this->tableExists($table)) {
            return collect();
        }

        $query = DB::table($table);

        if ($orderBy && Schema::hasColumn($table, $orderBy)) {
            $query->orderBy($orderBy);
        } elseif (Schema::hasColumn($table, 'created_at')) {
            $query->orderByDesc('created_at')->orderByDesc('id');
        } elseif (Schema::hasColumn($table, 'id')) {
            $query->orderByDesc('id');
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    protected function storeUploadedFiles(Request $request, string $entity, array $fields, ?object $record = null): array
    {
        $storedFiles = [];

        foreach ($fields as $field => $category) {
            if (!$request->hasFile($field)) {
                continue;
            }

            if ($record && !empty($record->{$field})) {
                $this->deleteFile($record->{$field});
            }

            $storedFiles[$field] = $this->storeFile(
                $request->file($field),
                'uploads/admin/' . $entity . '/' . $category
            );
        }

        return $storedFiles;
    }

    protected function deleteUploadedFiles(string $entity, object $record): void
    {
        foreach (array_keys($this->uploadFields($entity)) as $field) {
            if (!empty($record->{$field})) {
                $this->deleteFile($record->{$field});
            }
        }
    }

    protected function uploadFields(string $entity): array
    {
        return match ($entity) {
            'profil-sekolah' => ['upload_photo_profile_sekolah' => 'images'],
            'info-promo' => ['gambar' => 'images'],
            'kelompok-kelas' => ['upload_kelompok_kelas' => 'images'],
            'achievement' => ['gambar' => 'images'],
            'siswa' => [
                'upload_akte' => 'documents',
                'upload_kk' => 'documents',
                'upload_ijazah' => 'documents',
                'upload_foto' => 'images',
                'beasiswa_sertifikat_1' => 'documents',
                'beasiswa_sertifikat_2' => 'documents',
                'beasiswa_sertifikat_3' => 'documents',
                'beasiswa_video' => 'videos',
            ],
            'daftar-beasiswa' => [
                'sertifikat_1' => 'documents',
                'sertifikat_2' => 'documents',
                'sertifikat_3' => 'documents',
                'video' => 'videos',
            ],
            'daftar-reguler' => [
                'upload_akte' => 'documents',
                'upload_kk' => 'documents',
            ],
            default => [],
        };
    }

    protected function storeFile(UploadedFile $file, string $directory): string
    {
        $targetDirectory = public_path($directory);
        File::ensureDirectoryExists($targetDirectory);

        $filename = now()->format('YmdHis') . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($targetDirectory, $filename);

        return trim($directory . '/' . $filename, '/');
    }

    protected function deleteFile(string $relativePath): void
    {
        // Prevent directory traversal
        if (strpos($relativePath, '..') !== false) {
            return;
        }

        // Enforce that Admin can only delete files under uploads/admin/
        $normalizedPath = str_replace('\\', '/', trim($relativePath, '/'));
        if (strpos($normalizedPath, 'uploads/admin/') !== 0) {
            return;
        }

        $absolutePath = public_path($normalizedPath);

        if (File::exists($absolutePath)) {
            File::delete($absolutePath);
        }
    }

    protected function tableExists(string $table): bool
    {
        return Schema::hasTable($table);
    }

    protected function validationMessages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'exists' => ':attribute yang dipilih tidak valid.',
            'unique' => ':attribute sudah digunakan.',
            'after_or_equal' => ':attribute harus sama atau setelah tanggal mulai.',
            'mimes' => ':attribute memiliki format file yang tidak didukung.',
            'file' => ':attribute harus berupa file upload.',
        ];
    }

    protected function attributeLabels(): array
    {
        return $this->attributeLabelMap();
    }

    protected function attributeLabelMap(): array
    {
        return [
            'kd_users' => 'Kode user',
            'nama_beasiswa' => 'Nama beasiswa',
            'potongan_spp' => 'Potongan SPP',
            'nama_kelompok' => 'Nama kelompok',
            'dari_tahun_kelahiran' => 'Dari tahun kelahiran',
            'sampai_tahun_kelahiran' => 'Sampai tahun kelahiran',
            'nama_lengkap' => 'Nama lengkap',
            'tempat_lahir' => 'Tempat lahir',
            'tanggal_lahir' => 'Tanggal lahir',
            'jenis_kelamin' => 'Jenis kelamin',
            'nomor_hp' => 'Nomor HP',
            'nomor_hp_ayah' => 'Nomor HP ayah',
            'nomor_hp_ibu' => 'Nomor HP ibu',
            'status_pendaftaran' => 'Status pendaftaran',
            'status_aktif' => 'Status aktif',
            'id_kelompok_kelas' => 'Kelompok kelas',
            'id_jenis_beasiswa' => 'Jenis beasiswa',
            'tanggal_mulai' => 'Tanggal mulai',
            'tanggal_selesai' => 'Tanggal selesai',
            'jam_mulai' => 'Jam mulai',
            'jam_selesai' => 'Jam selesai',
            'upload_photo_profile_sekolah' => 'Foto profile sekolah',
            'upload_kelompok_kelas' => 'Upload kelompok kelas',
            'upload_akte' => 'Upload akte',
            'upload_kk' => 'Upload KK',
            'upload_ijazah' => 'Upload ijazah',
            'upload_foto' => 'Upload foto',
            'beasiswa_sertifikat_1' => 'Sertifikat beasiswa 1',
            'beasiswa_sertifikat_2' => 'Sertifikat beasiswa 2',
            'beasiswa_sertifikat_3' => 'Sertifikat beasiswa 3',
            'beasiswa_video' => 'Video beasiswa',
            'sertifikat_1' => 'Sertifikat 1',
            'sertifikat_2' => 'Sertifikat 2',
            'sertifikat_3' => 'Sertifikat 3',
            'video' => 'Video',
            'gambar' => 'Gambar',
        ];
    }

    protected function columnLabel(string $field): string
    {
        $labels = $this->attributeLabelMap();

        if (isset($labels[$field])) {
            return $labels[$field];
        }

        return Str::headline(str_replace('_', ' ', $field));
    }
}
