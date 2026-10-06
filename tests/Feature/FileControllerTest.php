<?php

namespace Tests\Feature;

use App\Models\File as ArchiveFile;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_pegawai_sees_only_their_own_archives(): void
    {
        $pegawai = $this->createPegawai('PEGAWAI-101');
        $otherPegawai = $this->createPegawai('PEGAWAI-102');
        $this->createArchive($pegawai, 'Arsip milik saya.pdf');
        $this->createArchive($otherPegawai, 'Arsip milik orang lain.pdf');

        $this->actingAs($pegawai)
            ->get(route('pegawai.arsip.index'))
            ->assertOk()
            ->assertSee('Arsip milik saya.pdf')
            ->assertDontSee('Arsip milik orang lain.pdf');
    }

    public function test_pegawai_can_upload_a_document_and_store_its_metadata(): void
    {
        Storage::fake();
        $pegawai = $this->createPegawai('PEGAWAI-103');
        $folder = Folder::create([
            'user_id' => $pegawai->id,
            'folder_name' => 'Arsip pribadi',
            'physical_path' => 'arsip_pegawai/nip_'.$pegawai->nip,
        ]);

        $this->actingAs($pegawai)
            ->post(route('pegawai.arsip.upload'), [
                'file_dokumen' => UploadedFile::fake()->create('surat.pdf', 100, 'application/pdf'),
            ])
            ->assertRedirect(route('pegawai.arsip.index'))
            ->assertSessionHas('success');

        $archive = ArchiveFile::firstOrFail();

        $this->assertDatabaseHas('files', [
            'folder_id' => $folder->id,
            'user_id' => $pegawai->id,
            'file_name_original' => 'surat.pdf',
        ]);
        Storage::assertExists($archive->file_path);
    }

    public function test_pegawai_cannot_upload_an_unsupported_file_type(): void
    {
        $pegawai = $this->createPegawai('PEGAWAI-107');
        Folder::create([
            'user_id' => $pegawai->id,
            'folder_name' => 'Arsip pribadi',
            'physical_path' => 'arsip_pegawai/nip_'.$pegawai->nip,
        ]);

        $this->actingAs($pegawai)
            ->from(route('pegawai.arsip.index'))
            ->post(route('pegawai.arsip.upload'), [
                'file_dokumen' => UploadedFile::fake()->create('program.exe', 20, 'application/octet-stream'),
            ])
            ->assertRedirect(route('pegawai.arsip.index'))
            ->assertSessionHasErrors('file_dokumen');

        $this->assertDatabaseCount('files', 0);
    }

    public function test_pegawai_cannot_download_another_users_archive(): void
    {
        Storage::fake();
        $pegawai = $this->createPegawai('PEGAWAI-104');
        $otherPegawai = $this->createPegawai('PEGAWAI-105');
        $archive = $this->createArchive($otherPegawai, 'rahasia.pdf');
        Storage::put($archive->file_path, 'private file');

        $this->actingAs($pegawai)
            ->get(route('file.download', $archive))
            ->assertForbidden();
    }

    public function test_admin_can_rename_and_delete_an_archive(): void
    {
        Storage::fake();
        $admin = User::factory()->create([
            'nip' => 'ADMIN-101',
            'role' => 'admin',
        ]);
        $pegawai = $this->createPegawai('PEGAWAI-106');
        $archive = $this->createArchive($pegawai, 'lama.pdf');
        Storage::put($archive->file_path, 'document');

        $this->actingAs($admin)
            ->put(route('admin.file.update', $archive), [
                'file_name_original' => 'nama-baru.pdf',
            ])
            ->assertRedirect(route('admin.arsip.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('files', [
            'id' => $archive->id,
            'file_name_original' => 'nama-baru.pdf',
        ]);

        $this->delete(route('admin.file.delete', $archive))
            ->assertRedirect(route('admin.arsip.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('files', ['id' => $archive->id]);
        Storage::assertMissing($archive->file_path);
    }

    private function createPegawai(string $nip): User
    {
        return User::factory()->create([
            'nip' => $nip,
            'role' => 'pegawai',
        ]);
    }

    private function createArchive(User $user, string $name): ArchiveFile
    {
        $folder = Folder::create([
            'user_id' => $user->id,
            'folder_name' => 'Arsip pribadi',
            'physical_path' => 'arsip_pegawai/nip_'.$user->nip,
        ]);

        return ArchiveFile::create([
            'folder_id' => $folder->id,
            'user_id' => $user->id,
            'file_name_original' => $name,
            'file_name_hash' => 'stored-'.$user->id.'-'.$name,
            'file_path' => $folder->physical_path.'/stored.pdf',
            'file_extension' => 'pdf',
            'file_size' => 100,
        ]);
    }
}
