<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminInputController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\SiswaProfileController;
use App\Http\Controllers\OrtuDashboardController;
use App\Http\Controllers\OrtuProfileController;
use App\Http\Controllers\CoachDashboardController;
use App\Http\Controllers\RegistrationController;


Route::get('/', [HomeController::class, 'index']);

Route::get('/achievements', [HomeController::class, 'achievements'])->name('achievements');

Route::get('/profile-sekolah', [HomeController::class, 'profileSekolah'])
    ->name('profile.sekolah');

Route::get('/schedule', [HomeController::class, 'schedule'])
    ->name('schedule');

Route::get('/agenda', [HomeController::class, 'agenda'])
    ->name('agenda');

Route::get('/tournament', [HomeController::class, 'tournament'])
    ->name('tournament');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/register', [RegistrationController::class, 'create'])
    ->name('register');

Route::post('/register', [RegistrationController::class, 'store'])
    ->name('register.store');

Route::get('/register/beasiswa', [RegistrationController::class, 'createBeasiswa'])
    ->name('register.beasiswa');

Route::post('/register/beasiswa', [RegistrationController::class, 'storeBeasiswa'])
    ->name('register.beasiswa.store');

Route::get('/register-success', function () {
    return view('auth.register-success');
})
->name('register.success');

Route::get('/register-beasiswa-success', function () {
    return view('auth.register-beasiswa-success');
})
->name('register.beasiswa.success');

Route::get('/cek-status', [RegistrationController::class, 'checkStatusForm'])
    ->name('check-status');

Route::post('/cek-status', [RegistrationController::class, 'checkStatus']);

Route::middleware(['auth', 'role:manajemen'])
    ->group(function () {
        Route::redirect('/admin', '/admin/dashboard');
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
        Route::get('/admin/forms', [AdminInputController::class, 'index'])
            ->name('admin.forms.index');
        Route::post('/admin/forms/{entity}', [AdminInputController::class, 'store'])
            ->name('admin.forms.store');
        Route::put('/admin/forms/{entity}/{id}', [AdminInputController::class, 'update'])
            ->name('admin.forms.update');
        Route::delete('/admin/forms/{entity}/{id}', [AdminInputController::class, 'destroy'])
            ->name('admin.forms.destroy');
        Route::post('/admin/forms/daftar-reguler/{id}/approve', [AdminInputController::class, 'approveDaftarReguler'])
            ->name('admin.forms.daftar-reguler.approve');
        Route::post('/admin/forms/daftar-reguler/{id}/reject', [AdminInputController::class, 'rejectDaftarReguler'])
            ->name('admin.forms.daftar-reguler.reject');
        Route::post('/admin/forms/daftar-beasiswa/{id}/approve', [AdminInputController::class, 'approveDaftarBeasiswa'])
            ->name('admin.forms.daftar-beasiswa.approve');
        Route::post('/admin/forms/daftar-beasiswa/{id}/reject', [AdminInputController::class, 'rejectDaftarBeasiswa'])
            ->name('admin.forms.daftar-beasiswa.reject');
    });

Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        Route::get(
            '/dashboard',
            [SiswaDashboardController::class, 'index']
        )
            ->name('dashboard');

        Route::get(
            '/profile',
            [SiswaProfileController::class, 'index']
        )
            ->name('profile');

        Route::get(
            '/orang-tua',
            [SiswaDashboardController::class, 'orangTua']
        )
            ->name('ortu');

        Route::get(
            '/kelompok-kelas',
            [SiswaDashboardController::class, 'kelompokKelas']
        )
            ->name('kelompok-kelas');

        Route::get(
            '/jadwal',
            [SiswaDashboardController::class, 'jadwal']
        )
            ->name('jadwal');

        Route::get(
            '/agenda',
            [SiswaDashboardController::class, 'agenda']
        )
            ->name('agenda');

        Route::get(
            '/tournament',
            [SiswaDashboardController::class, 'tournament']
        )
            ->name('tournament');

        Route::get(
            '/achievement',
            [SiswaDashboardController::class, 'achievement']
        )
            ->name('achievement');

        Route::post(
            '/profile/update',
            [SiswaProfileController::class, 'updateProfile']
        )->name('profile.update');

        Route::post(
            '/account/update',
            [SiswaProfileController::class, 'updateAccount']
        )->name('account.update');
    });

Route::middleware(['auth', 'role:ortu'])
    ->prefix('ortu')
    ->name('ortu.')
    ->group(function () {
        Route::get('/dashboard', [OrtuDashboardController::class, 'index'])->name('dashboard');
        Route::get('/anak', [OrtuDashboardController::class, 'anak'])->name('anak');
        Route::get('/profile', [OrtuProfileController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [OrtuProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('/account/update', [OrtuProfileController::class, 'updateAccount'])->name('account.update');
        Route::get('/kelompok-kelas', [OrtuDashboardController::class, 'kelompokKelas'])->name('kelompok-kelas');
        Route::get('/jadwal', [OrtuDashboardController::class, 'jadwal'])->name('jadwal');
        Route::get('/agenda', [OrtuDashboardController::class, 'agenda'])->name('agenda');
        Route::get('/tournament', [OrtuDashboardController::class, 'tournament'])->name('tournament');
        Route::get('/achievement', [OrtuDashboardController::class, 'achievement'])->name('achievement');
    });

Route::middleware(['auth', 'role:coach'])
    ->group(function () {

        Route::get(
            '/coach/dashboard',
            [CoachDashboardController::class, 'index']
        )
            ->name('coach.dashboard');
    });
Route::post('/api/test-user', function (\Illuminate\Http\Request $request) {

    return \App\Models\User::create([
        'kd_users' => $request->kd_users,
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'status_aktif' => true,
        'password' => \Illuminate\Support\Facades\Hash::make(
            $request->password
        )
    ]);
});
