<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // 2. Cek apakah role user saat ini cocok dengan role yang diizinkan pada route
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. Jika role tidak cocok, kembalikan ke dashboard masing-masing
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return redirect()->route('pegawai.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}