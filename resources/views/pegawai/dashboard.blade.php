@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
    <section class="welcome-hero relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-red-700 via-red-600 to-rose-500 px-6 py-8 text-white shadow-2xl shadow-red-900/20 sm:px-10 sm:py-10">
        <div class="absolute -right-16 -top-24 size-72 rounded-full border-[36px] border-white/10"></div>
        <div class="absolute -bottom-32 right-24 size-72 rounded-full border-[36px] border-white/10"></div>
        <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-red-50 ring-1 ring-white/20">
                    <span class="size-1.5 rounded-full bg-emerald-300"></span>
                    Area Pegawai
                </span>
                <h1 class="mt-4 text-3xl font-black tracking-tight sm:text-4xl">Selamat datang, {{ $user->name }}</h1>
                <p class="mt-3 text-sm leading-6 text-red-50 sm:text-base">Semua dokumen pribadi Anda tersimpan rapi dan dapat diakses kapan saja.</p>
            </div>
            <a href="{{ route('pegawai.arsip.index') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-bold text-red-700 shadow-lg transition hover:-translate-y-0.5 hover:bg-red-50">
                <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 2a.75.75 0 0 1 .75.75v6.5h6.5a.75.75 0 0 1 0 1.5h-6.5v6.5a.75.75 0 0 1-1.5 0v-6.5h-6.5a.75.75 0 0 1 0-1.5h6.5v-6.5A.75.75 0 0 1 10 2Z" clip-rule="evenodd"/></svg>
                Buka arsip saya
            </a>
        </div>
    </section>

    <div class="stats-grid mb-8 grid gap-5 sm:grid-cols-2">
        <section class="stat-card stat-red rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-900/5 sm:p-7">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Dokumen tersimpan</p>
                    <p class="mt-3 text-4xl font-black tracking-tight text-slate-950">{{ number_format($fileCount) }}</p>
                    <p class="mt-2 text-sm text-slate-500">Total arsip milik Anda</p>
                </div>
                <span class="flex size-14 items-center justify-center rounded-2xl bg-red-50 text-red-700">
                    <svg class="size-7" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3.75A1.75 1.75 0 0 1 8.75 2h6.19c.464 0 .909.184 1.237.513l3.31 3.31c.329.328.513.773.513 1.237v13.19A1.75 1.75 0 0 1 18.25 22h-9.5A1.75 1.75 0 0 1 7 20.25V3.75Z" stroke="currentColor" stroke-width="1.7"/><path d="M10 12h6m-6 4h6" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/></svg>
                </span>
            </div>
        </section>
        <section class="quick-action rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xl shadow-slate-900/5 sm:p-7">
            <p class="text-sm font-semibold text-slate-500">Aksi cepat</p>
            <h2 class="mt-3 text-xl font-bold text-slate-900">Simpan dokumen baru</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">Unggah PDF, JPG, PNG, atau DOCX dengan ukuran maksimal 5 MB.</p>
            <a href="{{ route('pegawai.arsip.index') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-red-700 transition hover:text-red-800">Pilih dokumen <span aria-hidden="true">&rarr;</span></a>
        </section>
    </div>

    <section class="recent-panel overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl shadow-slate-900/5">
        <div class="panel-header flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Arsip terbaru</h2>
                <p class="mt-1 text-sm text-slate-500">Dokumen pribadi yang terakhir Anda unggah.</p>
            </div>
            <a href="{{ route('pegawai.arsip.index') }}" class="text-sm font-bold text-red-700 transition hover:text-red-800">Lihat arsip saya <span aria-hidden="true">&rarr;</span></a>
        </div>

        @if ($recentFiles->isEmpty())
            <div class="empty-state px-6 py-14 text-center">
                <span class="mx-auto mb-4 flex size-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <svg class="size-7" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3.75A1.75 1.75 0 0 1 8.75 2h6.19c.464 0 .909.184 1.237.513l3.31 3.31c.329.328.513.773.513 1.237v13.19A1.75 1.75 0 0 1 18.25 22h-9.5A1.75 1.75 0 0 1 7 20.25V3.75Z" stroke="currentColor" stroke-width="1.7"/><path d="M10 12h6m-6 4h6" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/></svg>
                </span>
                <p class="font-semibold text-slate-800">Belum ada arsip</p>
                <p class="mt-1 text-sm text-slate-500">Mulai dengan mengunggah dokumen pertama Anda.</p>
            </div>
        @else
            <ul class="recent-list divide-y divide-slate-100">
                @foreach ($recentFiles as $file)
                    <li class="recent-item flex items-center gap-4 px-6 py-4 transition hover:bg-slate-50/80 sm:px-7">
                        <span class="document-icon flex size-11 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-700">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3.75A1.75 1.75 0 0 1 8.75 2h6.19c.464 0 .909.184 1.237.513l3.31 3.31c.329.328.513.773.513 1.237v13.19A1.75 1.75 0 0 1 18.25 22h-9.5A1.75 1.75 0 0 1 7 20.25V3.75Z" stroke="currentColor" stroke-width="1.7"/><path d="M10 12h6m-6 4h6" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/></svg>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-slate-800">{{ $file->file_name_original }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $file->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <a href="{{ route('file.download', $file) }}" class="rounded-lg px-3 py-2 text-xs font-bold text-red-700 transition hover:bg-red-50">Unduh</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
@endsection
