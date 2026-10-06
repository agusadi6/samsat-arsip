@extends('layouts.app')

@section('title', 'Arsip Saya')

@section('content')
    <div class="page-intro mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div class="upload-copy">
            <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-red-700">Ruang dokumen pribadi</p>
            <h1 class="text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">Arsip Saya</h1>
            <p class="mt-2 text-sm text-slate-500">Kelola dan temukan kembali dokumen pekerjaan Anda.</p>
        </div>
        <span class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 ring-1 ring-emerald-200">
            <span class="size-2 rounded-full bg-emerald-500"></span>
            Hanya Anda yang dapat melihat arsip ini
        </span>
    </div>

    <section class="upload-panel mb-7 overflow-hidden rounded-3xl border border-red-100 bg-gradient-to-br from-white via-white to-red-50 shadow-xl shadow-slate-900/5">
        <div class="grid gap-6 p-6 sm:p-8 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <span class="mb-3 inline-flex size-12 items-center justify-center rounded-2xl bg-red-100 text-red-700">
                    <svg class="size-6" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 16V4m0 0L7.5 8.5M12 4l4.5 4.5M5 14.5v4A1.5 1.5 0 0 0 6.5 20h11a1.5 1.5 0 0 0 1.5-1.5v-4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/></svg>
                </span>
                <h2 class="text-xl font-bold text-slate-900">Unggah dokumen baru</h2>
                <p class="mt-1 text-sm leading-6 text-slate-500">Format PDF, JPG, JPEG, PNG, atau DOCX. Ukuran maksimum 5 MB.</p>
            </div>
            <form class="flex flex-col gap-3 sm:flex-row sm:items-center" method="POST" action="{{ route('pegawai.arsip.upload') }}" enctype="multipart/form-data">
                @csrf
                <label for="file_dokumen" class="sr-only">Pilih dokumen</label>
                <input id="file_dokumen" name="file_dokumen" type="file" accept=".pdf,.jpg,.jpeg,.png,.docx" required class="block w-full cursor-pointer rounded-xl border border-slate-200 bg-white text-sm text-slate-600 shadow-sm file:mr-3 file:cursor-pointer file:border-0 file:bg-slate-100 file:px-4 file:py-3 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-red-50 sm:w-auto">
                <button type="submit" class="primary-button inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-red-900/15 transition hover:-translate-y-0.5 hover:bg-red-700">
                    <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 2a.75.75 0 0 1 .75.75v6.5h6.5a.75.75 0 0 1 0 1.5h-6.5v6.5a.75.75 0 0 1-1.5 0v-6.5h-6.5a.75.75 0 0 1 0-1.5h6.5v-6.5A.75.75 0 0 1 10 2Z" clip-rule="evenodd"/></svg>
                    Unggah
                </button>
            </form>
        </div>
    </section>

    <section class="archive-panel overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl shadow-slate-900/5">
        <div class="panel-header flex flex-col gap-2 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Dokumen tersimpan</h2>
                <p class="mt-1 text-sm text-slate-500">Daftar dokumen yang telah Anda unggah.</p>
            </div>
            <span class="w-fit rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $files->total() }} dokumen</span>
        </div>

        @if ($files->isEmpty())
            <div class="empty-state px-6 py-16 text-center">
                <span class="mx-auto mb-4 flex size-16 items-center justify-center rounded-3xl bg-slate-100 text-slate-400">
                    <svg class="size-8" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3.75A1.75 1.75 0 0 1 8.75 2h6.19c.464 0 .909.184 1.237.513l3.31 3.31c.329.328.513.773.513 1.237v13.19A1.75 1.75 0 0 1 18.25 22h-9.5A1.75 1.75 0 0 1 7 20.25V3.75Z" stroke="currentColor" stroke-width="1.7"/><path d="M10 12h6m-6 4h6" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/></svg>
                </span>
                <p class="font-bold text-slate-800">Belum ada dokumen</p>
                <p class="mt-1 text-sm text-slate-500">Pilih file di atas untuk mengunggah arsip pertama Anda.</p>
            </div>
        @else
            <div class="archive-table-wrap overflow-x-auto">
                <table class="archive-table w-full min-w-[720px] text-left text-sm">
                    <thead class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-4 font-bold sm:px-7">Nama dokumen</th>
                            <th class="px-4 py-4 font-bold">Format</th>
                            <th class="px-4 py-4 font-bold">Ukuran</th>
                            <th class="px-4 py-4 font-bold">Tanggal unggah</th>
                            <th class="px-6 py-4 font-bold sm:px-7">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($files as $file)
                            <tr class="transition hover:bg-slate-50/70">
                                <td class="px-6 py-4 sm:px-7">
                                    <div class="flex items-center gap-3">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-700">
                                            <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3.75A1.75 1.75 0 0 1 8.75 2h6.19c.464 0 .909.184 1.237.513l3.31 3.31c.329.328.513.773.513 1.237v13.19A1.75 1.75 0 0 1 18.25 22h-9.5A1.75 1.75 0 0 1 7 20.25V3.75Z" stroke="currentColor" stroke-width="1.7"/><path d="M10 12h6m-6 4h6" stroke="currentColor" stroke-linecap="round" stroke-width="1.7"/></svg>
                                        </span>
                                        <span class="max-w-xs truncate font-semibold text-slate-800">{{ $file->file_name_original }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4"><span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-bold uppercase text-slate-600">{{ $file->file_extension }}</span></td>
                                <td class="px-4 py-4 whitespace-nowrap text-slate-600">{{ number_format($file->file_size / 1024, 1) }} KB</td>
                                <td class="px-4 py-4 whitespace-nowrap text-slate-500">{{ $file->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 sm:px-7">
                                    <a href="{{ route('file.download', $file) }}" class="inline-flex items-center gap-2 rounded-lg px-3 py-2 font-bold text-red-700 transition hover:bg-red-50">
                                        <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 2a.75.75 0 0 1 .75.75v8.19l2.22-2.22a.75.75 0 1 1 1.06 1.06l-3.5 3.5a.75.75 0 0 1-1.06 0l-3.5-3.5a.75.75 0 1 1 1.06-1.06l2.22 2.22V2.75A.75.75 0 0 1 10 2ZM3.75 13a.75.75 0 0 1 .75.75v2.5c0 .138.112.25.25.25h10.5a.25.25 0 0 0 .25-.25v-2.5a.75.75 0 0 1 1.5 0v2.5A1.75 1.75 0 0 1 15.25 18h-10.5A1.75 1.75 0 0 1 3 16.25v-2.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                                        Unduh
                                    </a>
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
