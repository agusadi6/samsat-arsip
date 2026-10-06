@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="page-intro mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-red-700">Ringkasan sistem</p>
            <h1 class="text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">Dashboard Admin</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500 sm:text-base">Pantau pegawai dan kelola seluruh dokumen arsip dari satu tempat.</p>
        </div>
        <a href="{{ route('admin.arsip.index') }}" class="primary-link inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-red-900/20 transition hover:-translate-y-0.5 hover:bg-red-700">
            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M3 4.75A1.75 1.75 0 0 1 4.75 3h10.5A1.75 1.75 0 0 1 17 4.75v10.5A1.75 1.75 0 0 1 15.25 17H4.75A1.75 1.75 0 0 1 3 15.25V4.75Zm3.5.75a.75.75 0 0 0 0 1.5h7a.75.75 0 0 0 0-1.5h-7Zm0 3.75a.75.75 0 0 0 0 1.5h7a.75.75 0 0 0 0-1.5h-7Zm0 3.75a.75.75 0 0 0 0 1.5H11a.75.75 0 0 0 0-1.5H6.5Z"/></svg>
            Kelola semua arsip
        </a>
    </div>

    <div class="stats-grid mb-8 grid gap-5 sm:grid-cols-2">
        <section class="stat-card stat-blue relative overflow-hidden rounded-3xl border border-white bg-white p-6 shadow-xl shadow-slate-900/5 sm:p-7">
            <div class="absolute -right-6 -top-8 size-36 rounded-full bg-blue-100/70 blur-2xl"></div>
            <div class="relative flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Total pegawai</p>
                    <p class="mt-3 text-4xl font-black tracking-tight text-slate-950">{{ number_format($pegawaiCount) }}</p>
                    <p class="mt-2 text-sm text-slate-500">Akun pegawai terdaftar</p>
                </div>
                <span class="flex size-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                    <svg class="size-7" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M16 20v-1.5a4.5 4.5 0 0 0-4.5-4.5h-5A4.5 4.5 0 0 0 2 18.5V20m17 0v-1.5a4.5 4.5 0 0 0-3-4.243M14.5 3.243a4.5 4.5 0 0 1 0 8.514M9 10a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/></svg>
                </span>
            </div>
        </section>

        <section class="stat-card stat-red relative overflow-hidden rounded-3xl border border-white bg-white p-6 shadow-xl shadow-slate-900/5 sm:p-7">
            <div class="absolute -right-6 -top-8 size-36 rounded-full bg-red-100/80 blur-2xl"></div>
            <div class="relative flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Total dokumen</p>
                    <p class="mt-3 text-4xl font-black tracking-tight text-slate-950">{{ number_format($fileCount) }}</p>
                    <p class="mt-2 text-sm text-slate-500">Dokumen yang tersimpan</p>
                </div>
                <span class="flex size-14 items-center justify-center rounded-2xl bg-red-50 text-red-700">
                    <svg class="size-7" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3.75A1.75 1.75 0 0 1 8.75 2h6.19c.464 0 .909.184 1.237.513l3.31 3.31c.329.328.513.773.513 1.237v13.19A1.75 1.75 0 0 1 18.25 22h-9.5A1.75 1.75 0 0 1 7 20.25V3.75Z" stroke="currentColor" stroke-width="1.7"/><path d="M14 2.5V7h4.5M10 12h6m-6 4h6" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/></svg>
                </span>
            </div>
        </section>
    </div>

    <section class="recent-panel overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl shadow-slate-900/5">
        <div class="panel-header flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Dokumen terbaru</h2>
                <p class="mt-1 text-sm text-slate-500">Arsip yang baru saja diunggah pegawai.</p>
            </div>
            <a href="{{ route('admin.arsip.index') }}" class="text-sm font-bold text-red-700 transition hover:text-red-800">Lihat semua <span aria-hidden="true">&rarr;</span></a>
        </div>

        @if ($recentFiles->isEmpty())
            <div class="empty-state px-6 py-14 text-center">
                <span class="mx-auto mb-4 flex size-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <svg class="size-7" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3.75A1.75 1.75 0 0 1 8.75 2h6.19c.464 0 .909.184 1.237.513l3.31 3.31c.329.328.513.773.513 1.237v13.19A1.75 1.75 0 0 1 18.25 22h-9.5A1.75 1.75 0 0 1 7 20.25V3.75Z" stroke="currentColor" stroke-width="1.7"/><path d="M10 12h6m-6 4h6" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/></svg>
                </span>
                <p class="font-semibold text-slate-800">Belum ada arsip</p>
                <p class="mt-1 text-sm text-slate-500">Dokumen yang diunggah akan muncul di sini.</p>
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
                            <p class="mt-1 truncate text-xs text-slate-500">{{ $file->user?->name ?? 'Pegawai tidak diketahui' }} · {{ $file->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="hidden rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-bold uppercase tracking-wide text-slate-600 sm:inline-flex">{{ $file->file_extension }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
@endsection
