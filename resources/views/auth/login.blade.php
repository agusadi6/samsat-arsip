@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
    <div class="auth-card login-card mx-auto grid max-w-5xl overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white shadow-2xl shadow-slate-900/10 md:grid-cols-2">
        <section class="auth-aside login-aside relative hidden min-h-[560px] overflow-hidden bg-gradient-to-br from-red-800 via-red-700 to-rose-500 p-10 text-white md:flex md:flex-col md:justify-between">
            <div class="absolute -right-28 -top-20 size-96 rounded-full border-[44px] border-white/10"></div>
            <div class="absolute -bottom-36 -left-24 size-96 rounded-full border-[44px] border-white/10"></div>
            <div class="auth-content relative">
                <span class="inline-flex size-14 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/25">
                    <svg class="size-8" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 4.75A1.75 1.75 0 0 1 6.75 3h10.5A1.75 1.75 0 0 1 19 4.75v14.5A1.75 1.75 0 0 1 17.25 21H6.75A1.75 1.75 0 0 1 5 19.25V4.75Z" stroke="currentColor" stroke-width="1.7"/><path d="M8.5 8h7m-7 4h7m-7 4h4" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/></svg>
                </span>
                <p class="mt-8 text-xs font-bold uppercase tracking-[0.2em] text-red-100">Sistem Arsip Digital</p>
                <h1 class="mt-3 text-4xl font-black leading-tight tracking-tight">Semua dokumen penting, tersimpan aman.</h1>
                <p class="mt-4 max-w-sm leading-7 text-red-100">Akses arsip kerja Anda dengan mudah melalui satu sistem yang praktis dan teratur.</p>
            </div>
            <div class="auth-feature relative flex items-center gap-3 rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur">
                <span class="flex size-10 items-center justify-center rounded-xl bg-white/15">
                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 1.75a.75.75 0 0 1 .75.75v.57a7.002 7.002 0 0 1 5.18 10.77l.4.4a.75.75 0 1 1-1.06 1.06l-.4-.4a7.002 7.002 0 0 1-10.77-5.18h-.57a.75.75 0 0 1 0-1.5h.57a7.002 7.002 0 0 1 5.18-5.18v-.57a.75.75 0 0 1 .75-.75Zm0 4.25a.75.75 0 0 1 .75.75v2.94l1.78 1.78a.75.75 0 1 1-1.06 1.06l-2-2A.75.75 0 0 1 9.25 10V6.75a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                </span>
                <p class="text-sm font-semibold text-white">Aman, terorganisir, dan selalu siap diakses.</p>
            </div>
        </section>

        <section class="auth-form-panel flex items-center px-6 py-10 sm:px-10 md:px-12">
            <div class="mx-auto w-full max-w-sm">
                <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-red-700 md:hidden">Sistem Arsip Digital</span>
                <h2 class="mt-4 text-3xl font-black tracking-tight text-slate-950">Selamat datang</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">
                    {{ $adminLogin ? 'Masuk menggunakan akun Admin untuk melanjutkan.' : 'Masuk menggunakan akun pegawai Anda untuk melanjutkan.' }}
                </p>

                <form class="auth-form mt-8 space-y-5" method="POST" action="{{ $adminLogin ? route('admin.login.submit') : route('login') }}">
                    @csrf
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email{{ $adminLogin ? ' Admin' : '' }}</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-4 focus:ring-red-500/10" placeholder="nama@email.com">
                    </div>
                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Kata sandi</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-4 focus:ring-red-500/10" placeholder="Masukkan kata sandi">
                    </div>
                    <button type="submit" class="primary-button inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-red-900/20 transition hover:-translate-y-0.5 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500/20">
                        {{ $adminLogin ? 'Masuk sebagai Admin' : 'Masuk ke akun' }}
                        <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.69L10.22 5.03a.75.75 0 1 1 1.06-1.06l5.5 5.5a.75.75 0 0 1 0 1.06l-5.5 5.5a.75.75 0 0 1-1.06-1.06l4.22-4.22H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/></svg>
                    </button>
                </form>

                @if ($adminLogin)
                    <p class="login-footer mt-7 text-center text-sm text-slate-500">Login pegawai? <a class="font-bold text-red-700 transition hover:text-red-800" href="{{ route('login') }}">Kembali ke login pegawai</a></p>
                @else
                    <p class="login-footer mt-7 text-center text-sm text-slate-500">Belum punya akun? <a class="font-bold text-red-700 transition hover:text-red-800" href="{{ route('register') }}">Daftar sekarang</a></p>
                    <p class="admin-login-link">Admin? <a href="{{ route('admin.login') }}">Login khusus Admin</a></p>
                @endif
            </div>
        </section>
    </div>
@endsection
