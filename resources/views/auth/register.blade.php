@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
    <div class="auth-card register-card mx-auto grid max-w-5xl overflow-hidden rounded-[2rem] border border-slate-200/80 bg-white shadow-2xl shadow-slate-900/10 md:grid-cols-2">
        <section class="auth-aside register-aside relative hidden min-h-[660px] overflow-hidden bg-gradient-to-br from-slate-950 via-slate-800 to-red-900 p-10 text-white md:flex md:flex-col md:justify-between">
            <div class="absolute -right-28 -top-20 size-96 rounded-full border-[44px] border-white/5"></div>
            <div class="absolute -bottom-36 -left-24 size-96 rounded-full border-[44px] border-red-400/10"></div>
            <div class="auth-content relative">
                <span class="inline-flex size-14 items-center justify-center rounded-2xl bg-red-500/20 text-red-200 ring-1 ring-red-200/20">
                    <svg class="size-8" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg>
                </span>
                <p class="mt-8 text-xs font-bold uppercase tracking-[0.2em] text-red-200">Mulai sekarang</p>
                <h1 class="mt-3 text-4xl font-black leading-tight tracking-tight">Buat akun pegawai Anda.</h1>
                <p class="mt-4 max-w-sm leading-7 text-slate-300">Satu akun untuk menyimpan dan mengelola dokumen pekerjaan Anda dengan lebih mudah.</p>
            </div>
            <div class="auth-feature relative rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                <p class="text-sm font-semibold">Pendaftaran akun baru memberikan akses sebagai pegawai.</p>
                <p class="mt-2 text-sm leading-6 text-slate-300">Isi data yang benar agar akun dan arsip pribadi Anda terhubung dengan tepat.</p>
            </div>
        </section>

        <section class="auth-form-panel px-6 py-9 sm:px-10 md:px-12">
            <div class="mx-auto w-full max-w-sm">
                <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-red-700 md:hidden">Pendaftaran Pegawai</span>
                <h2 class="mt-4 text-3xl font-black tracking-tight text-slate-950">Buat akun</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">Lengkapi informasi berikut untuk membuat akun arsip.</p>

                <form class="auth-form register-form mt-7 space-y-4" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div>
                        <label for="nip" class="mb-1.5 block text-sm font-semibold text-slate-700">NIP</label>
                        <input id="nip" name="nip" type="text" value="{{ old('nip') }}" autocomplete="username" required autofocus class="block w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-500/10" placeholder="Masukkan NIP">
                    </div>
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required class="block w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-500/10" placeholder="Nama sesuai identitas">
                    </div>
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required class="block w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-500/10" placeholder="nama@email.com">
                    </div>
                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Kata sandi</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required class="block w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-500/10" placeholder="Minimal 8 karakter">
                    </div>
                    <div>
                        <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-slate-700">Ulangi kata sandi</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="block w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-red-500 focus:ring-4 focus:ring-red-500/10" placeholder="Ketik ulang kata sandi">
                    </div>
                    <button type="submit" class="primary-button inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-red-900/20 transition hover:-translate-y-0.5 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-500/20">
                        Buat akun pegawai
                        <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 2a.75.75 0 0 1 .75.75v6.5h6.5a.75.75 0 0 1 0 1.5h-6.5v6.5a.75.75 0 0 1-1.5 0v-6.5h-6.5a.75.75 0 0 1 0-1.5h6.5v-6.5A.75.75 0 0 1 10 2Z" clip-rule="evenodd"/></svg>
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-500">Sudah punya akun? <a class="font-bold text-red-700 transition hover:text-red-800" href="{{ route('login') }}">Masuk</a></p>
            </div>
        </section>
    </div>
@endsection
