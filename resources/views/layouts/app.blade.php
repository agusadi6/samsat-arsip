<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f8fafc">
    <title>@yield('title', 'Sistem Arsip') | Arsip Samsat</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="app-shell min-h-screen bg-slate-50 font-sans text-slate-800 antialiased">
    <div class="pointer-events-none fixed inset-x-0 top-0 -z-10 h-96 bg-gradient-to-b from-red-100/60 via-orange-50/40 to-transparent"></div>

    <header class="site-header sticky top-0 z-20 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
        <nav class="site-nav mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="brand group inline-flex items-center gap-3">
                <span class="brand-mark flex size-11 items-center justify-center rounded-2xl bg-gradient-to-br from-red-600 to-rose-700 text-white shadow-lg shadow-red-900/20 transition group-hover:-rotate-3 group-hover:scale-105">
                    <svg class="size-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M5 4.75A1.75 1.75 0 0 1 6.75 3h10.5A1.75 1.75 0 0 1 19 4.75v14.5A1.75 1.75 0 0 1 17.25 21H6.75A1.75 1.75 0 0 1 5 19.25V4.75Z" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M8.5 8h7M8.5 12h7m-7 4h4" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/>
                    </svg>
                </span>
                <span>
                    <span class="block text-sm font-bold tracking-tight text-slate-900 sm:text-base">ARSIP SAMSAT</span>
                    <span class="block text-xs font-medium text-slate-500">Pusat dokumen digital</span>
                </span>
            </a>

            <div class="site-nav-links flex flex-wrap items-center gap-2 sm:gap-3">
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Dashboard</a>
                        <a href="{{ route('admin.arsip.index') }}" class="rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Semua Arsip</a>
                    @else
                        <a href="{{ route('pegawai.dashboard') }}" class="rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Dashboard</a>
                        <a href="{{ route('pegawai.arsip.index') }}" class="rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Arsip Saya</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-700">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-md shadow-red-900/15 transition hover:bg-red-700 hover:shadow-lg">Daftar</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="site-main mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        @if (session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-sm" role="status">
                <svg class="mt-0.5 size-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.78-9.22a.75.75 0 0 0-1.06-1.06l-3.47 3.47-1.47-1.47a.75.75 0 0 0-1.06 1.06l2 2a.75.75 0 0 0 1.06 0l4-4Z" clip-rule="evenodd"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800 shadow-sm" role="alert">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 shadow-sm" role="alert">
                <p class="font-semibold">Periksa kembali data yang Anda masukkan:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-slate-200/80 bg-white/70">
        <div class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-5 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <span>&copy; {{ date('Y') }} Sistem Arsip Samsat</span>
            <span>Pengelolaan dokumen yang aman dan teratur</span>
        </div>
    </footer>
</body>
</html>
