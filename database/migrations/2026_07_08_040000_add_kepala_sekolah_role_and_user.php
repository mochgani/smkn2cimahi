<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Tambah role `kepala_sekolah`:
     * - Bisa membuat berita sendiri, langsung publish (tidak perlu approval,
     *   sama seperti super_admin) — lihat CreateBerita::mutateFormDataBeforeCreate
     * - Bisa melihat & approve/reject SEMUA berita lintas divisi/kompetensi
     *   (seperti manajemen_mutu) — lihat BeritaResource::getEloquentQuery
     * - Hanya bisa edit/hapus berita miliknya sendiri (created_by), tidak
     *   boleh utak-atik konten divisi/kompetensi lain
     * - Punya akses penuh ke resource Profil Sekolah (Sejarah, Unggulan,
     *   Visi & Misi) dan Profil Kepala Sekolah (identitas + sambutan)
     */
    public function up(): void
    {
        Role::firstOrCreate(['name' => 'kepala_sekolah', 'guard_name' => 'web']);

        $user = User::updateOrCreate(
            ['email' => 'kepalasekolah@smkn2cmi.sch.id'],
            [
                'name'     => 'Kepala Sekolah',
                'password' => Hash::make('@smkn2cmi'),
            ]
        );
        $user->syncRoles(['kepala_sekolah']);
    }

    public function down(): void
    {
        // Tidak dihapus otomatis - kelola manual via /admin/users bila perlu.
    }
};
