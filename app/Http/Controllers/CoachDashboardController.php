<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CoachDashboardController extends Controller
{
    public function index()
    {
        return view('coach.dashboard', [
            'user' => Auth::user()
        ]);
    }
}