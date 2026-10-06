@extends('layouts.app')

@section('title', 'Manajemen Arsip')

@section('content')
    <div class="page-intro mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-red-700">Pusat pengelolaan</p>
            <h1 class="text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">Seluruh Arsip</h1>
            <p class="mt-2 text-sm text-slate-500">Kelola dokumen yang diunggah oleh semua pegawai.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex w-fit items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 0 1 1.06 1.06l-3.22 3.22h10.69A.75.75 0 0 1 17 10Z" clip-rule="evenodd"/></svg>
            Kembali ke dashboard
        </a>
    </div>

    <section class="archive-panel overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl shadow-slate-900/5">
        <div class="panel-header flex flex-col gap-2 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Daftar dokumen pegawai</h2>
                <p class="mt-1 text-sm text-slate-500">Admin dapat mengunduh, mengganti nama, atau menghapus arsip.</p>
            </div>
            <span class="w-fit rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $files->total() }} dokumen</span>
        </div>

        @if ($files->isEmpty())
            <div class="empty-state px-6 py-16 text-center">
                <span class="mx-auto mb-4 flex size-16 items-center justify-center rounded-3xl bg-slate-100 text-slate-400">
                    <svg class="size-8" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3.75A1.75 1.75 0 0 1 8.75 2h6.19c.464 0 .909.184 1.237.513l3.31 3.31c.329.328.513.773.513 1.237v13.19A1.75 1.75 0 0 1 18.25 22h-9.5A1.75 1.75 0 0 1 7 20.25V3.75Z" stroke="currentColor" stroke-width="1.7"/><path d="M10 12h6m-6 4h6" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/></svg>
                </span>
                <p class="font-bold text-slate-800">Belum ada dokumen</p>
                <p class="mt-1 text-sm text-slate-500">Dokumen pegawai akan tercantum di halaman ini.</p>
            </div>
        @else
            <div class="archive-table-wrap overflow-x-auto">
                <table class="archive-table admin-archive-table w-full min-w-[1120px] text-left text-sm">
                    <thead class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-4 font-bold sm:px-7">Dokumen</th>
                            <th class="px-4 py-4 font-bold">Pemilik</th>
                            <th class="px-4 py-4 font-bold">NIP</th>
                            <th class="px-4 py-4 font-bold">Info file</th>
                            <th class="px-4 py-4 font-bold">Tanggal</th>
                            <th class="px-6 py-4 font-bold sm:px-7">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($files as $file)
                            <tr class="align-top transition hover:bg-slate-50/70">
                                <td class="px-6 py-4 sm:px-7">
                                    <div class="flex max-w-xs items-center gap-3">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-700">
                                            <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3.75A1.75 1.75 0 0 1 8.75 2h6.19c.464 0 .909.184 1.237.513l3.31 3.31c.329.328.513.773.513 1.237v13.19A1.75 1.75 0 0 1 18.25 22h-9.5A1.75 1.75 0 0 1 7 20.25V3.75Z" stroke="currentColor" stroke-width="1.7"/><path d="M10 12h6m-6 4h6" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/></svg>
                                        </span>
                                        <span class="truncate font-semibold text-slate-800">{{ $file->file_name_original }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 font-medium text-slate-700">{{ $file->user?->name ?? 'Pegawai tidak diketahui' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-slate-500">{{ $file->user?->nip ?? '—' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-bold uppercase text-slate-600">{{ $file->file_extension }}</span>
                                    <span class="ml-1 text-xs text-slate-500">{{ number_format($file->file_size / 1024, 1) }} KB</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-slate-500">{{ $file->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 sm:px-7">
                                    <div class="flex min-w-[260px] flex-col gap-2">
                                        <a href="{{ route('file.download', $file) }}" class="inline-flex w-fit items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-bold text-red-700 transition hover:bg-red-50">
                                            <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 2a.75.75 0 0 1 .75.75v8.19l2.22-2.22a.75.75 0 1 1 1.06 1.06l-3.5 3.5a.75.75 0 0 1-1.06 0l-3.5-3.5a.75.75 0 1 1 1.06-1.06l2.22 2.22V2.75A.75.75 0 0 1 10 2ZM3.75 13a.75.75 0 0 1 .75.75v2.5c0 .138.112.25.25.25h10.5a.25.25 0 0 0 .25-.25v-2.5a.75.75 0 0 1 1.5 0v2.5A1.75 1.75 0 0 1 15.25 18h-10.5A1.75 1.75 0 0 1 3 16.25v-2.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                                            Unduh dokumen
                                        </a>
                                        <form class="flex gap-2" method="POST" action="{{ route('admin.file.update', $file) }}">
                                            @csrf
                                            @method('PUT')
                                            <label class="sr-only" for="file-name-{{ $file->id }}">Nama dokumen</label>
                                            <input id="file-name-{{ $file->id }}" class="min-w-0 flex-1 rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-700 outline-none transition focus:border-red-400 focus:ring-4 focus:ring-red-500/10" name="file_name_original" type="text" value="{{ $file->file_name_original }}" maxlength="255" required>
                                            <button type="submit" class="rounded-lg bg-slate-800 px-3 py-2 text-xs font-bold text-white transition hover:bg-slate-950">Simpan</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.file.delete', $file) }}" onsubmit="return confirm('Yakin ingin menghapus arsip ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg px-2.5 py-1.5 text-xs font-bold text-red-700 transition hover:bg-red-50">Hapus arsip</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($files->hasPages())
                <div class="border-t border-slate-100 px-6 py-4 sm:px-7">{{ $files->links() }}</div>
            @endif
        @endif
    </section>
@endsection
