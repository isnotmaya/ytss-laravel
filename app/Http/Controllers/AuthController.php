<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        $stats = $this->getPortalStats();
        return view('auth.login', compact('stats'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        switch ($user->role) {

            case 'manajemen':
                return redirect()->route('admin.dashboard');

            case 'siswa':
                return redirect()->route('siswa.dashboard');

            case 'ortu':
                return redirect()->route('ortu.dashboard');

            case 'coach':
                return redirect()->route('coach.dashboard');

            default:
                Auth::logout();
                return redirect()->route('login');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}