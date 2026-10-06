<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Register extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nip'      => 'required|string|unique:users,nip',
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Gunakan Transaction untuk memastikan jika folder gagal dibuat, user tidak tersimpan
        DB::transaction(function () use ($request) {
            // 2. Simpan Data User (Default role: pegawai)
            $user = User::create([
                'nip'      => $request->nip,
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'pegawai',
            ]);

            // 3. Tentukan Path Folder Fisik di Server
            $folderPath = 'arsip_pegawai/nip_' . $user->nip;

            // 4. Buat Direktori Fisik di storage/app/arsip_pegawai/nip_xxx
            Storage::makeDirectory($folderPath);

            // 5. Catat Virtual Folder di Database
            Folder::create([
                'user_id'       => $user->id,
                'folder_name'   => 'Arsip Pribadi - ' . $user->name,
                'physical_path' => $folderPath,
            ]);
        });

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
