<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class Pegawai extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        abort_unless($user instanceof User, 403);

        $fileCount = $user->files()->count();
        $recentFiles = $user->files()
            ->latest()
            ->take(5)
            ->get();

        return view('pegawai.dashboard', compact('user', 'fileCount', 'recentFiles'));
    }
}
