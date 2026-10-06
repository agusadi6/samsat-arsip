<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class Login extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login', ['adminLogin' => false]);
    }

    public function showAdminLoginForm(): View
    {
        return view('auth.login', ['adminLogin' => true]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $this->credentials($request);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan Role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('pegawai.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    public function adminLogin(Request $request): RedirectResponse
    {
        $credentials = $this->credentials($request);

        if (Auth::attempt($credentials + ['role' => 'admin'])) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password Admin tidak cocok.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * @return array{email: string, password: string}
     */
    private function credentials(Request $request): array
    {
        return $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
    }
}
