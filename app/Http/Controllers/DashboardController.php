<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(): RedirectResponse
    {
        $user = request()->user();

        return match ($user->role) {
            UserRole::Mahasiswa => redirect()->route('dashboard.mahasiswa'),
            UserRole::DosenPa => redirect()->route('dashboard.dosen-pa'),
            UserRole::Kaprodi => redirect()->route('dashboard.kaprodi'),
            UserRole::Dekan => redirect()->route('dashboard.dekan'),
        };
    }
}
