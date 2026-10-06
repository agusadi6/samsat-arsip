<?php

namespace App\Http\Controllers;

use App\Models\File as ArchiveFile;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class FileController extends Controller
{
    public function myFiles(): View
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        $files = $user->files()->latest()->paginate(10);

        return view('pegawai.arsip', compact('files', 'user'));
    }

    public function upload(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'file_dokumen' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,docx', 'max:5120'],
        ]);

        $user = $request->user();
        abort_unless($user instanceof User, 403);

        $folder = Folder::whereBelongsTo($user)->firstOrFail();
        $uploadedFile = $validated['file_dokumen'];
        $extension = $uploadedFile->extension();
        $storedName = Str::uuid().'.'.$extension;
        $path = $uploadedFile->storeAs($folder->physical_path, $storedName);

        if ($path === false) {
            throw new RuntimeException('Dokumen gagal disimpan ke penyimpanan.');
        }

        try {
            DB::transaction(function () use ($folder, $user, $uploadedFile, $path, $storedName, $extension): void {
                ArchiveFile::create([
                    'folder_id' => $folder->id,
                    'user_id' => $user->id,
                    'file_name_original' => $uploadedFile->getClientOriginalName(),
                    'file_name_hash' => $storedName,
                    'file_path' => $path,
                    'file_extension' => $extension,
                    'file_size' => $uploadedFile->getSize(),
                ]);
            });
        } catch (Throwable $exception) {
            if (! Storage::delete($path)) {
                report(new RuntimeException('File upload gagal disimpan dan file sementara tidak dapat dibersihkan.'));
            }

            throw $exception;
        }

        return redirect()
            ->route('pegawai.arsip.index')
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    public function download(ArchiveFile $file)
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        if ($user->role !== 'admin' && $file->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        return Storage::download($file->file_path, $file->file_name_original);
    }

    public function allFiles(): View
    {
        $files = ArchiveFile::with('user:id,name,nip')
            ->latest()
            ->paginate(15);

        return view('admin.arsip', compact('files'));
    }

    public function update(Request $request, ArchiveFile $file): RedirectResponse
    {
        $validated = $request->validate([
            'file_name_original' => ['required', 'string', 'max:255'],
        ]);

        $file->update($validated);

        return redirect()
            ->route('admin.arsip.index')
            ->with('success', 'Nama arsip berhasil diperbarui.');
    }

    public function destroy(ArchiveFile $file): RedirectResponse
    {
        if (Storage::exists($file->file_path) && ! Storage::delete($file->file_path)) {
            throw new RuntimeException('File fisik gagal dihapus; data arsip tidak diubah.');
        }

        $file->delete();

        return redirect()
            ->route('admin.arsip.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }
}
