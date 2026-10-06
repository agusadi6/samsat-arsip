<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Contracts\View\View;

class Admin extends Controller
{
    public function index(): View
    {
        $pegawaiCount = User::where('role', 'pegawai')->count();
        $fileCount = File::count();
        $recentFiles = File::with('user:id,name,nip')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('pegawaiCount', 'fileCount', 'recentFiles'));
    }
}
