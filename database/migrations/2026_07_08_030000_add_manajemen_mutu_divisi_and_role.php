<?php

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Tambah divisi "Manajemen Mutu" + role baru `manajemen_mutu`.
     * Role ini bisa melihat & approve/reject SEMUA berita lintas divisi
     * dan kompetensi (beda dari role `divisi` biasa yang cuma bisa lihat
     * beritanya sendiri), tapi tidak bisa create/edit/delete konten
     * (lihat BeritaResource::canCreate/canEdit/canDelete).
     */
    public function up(): void
    {
        Role::firstOrCreate(['name' => 'manajemen_mutu', 'guard_name' => 'web']);

        $divisi = Divisi::firstOrCreate(
            ['slug' => 'manajemen-mutu'],
            [
                'name'          => 'Manajemen Mutu',
                'description'   => 'Divisi Manajemen Mutu — validasi berita/konten dari semua divisi dan kompetensi keahlian.',
                'display_order' => 5,
                'is_active'     => true,
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'mutu@smkn2cmi.sch.id'],
            [
                'name'      => 'Manajemen Mutu',
                'password'  => Hash::make('@smkn2cmi'),
                'divisi_id' => $divisi->id,
            ]
        );
        $user->syncRoles(['manajemen_mutu']);
    }

    public function down(): void
    {
        // Tidak dihapus otomatis - kelola manual via /admin/users & /admin/divisis bila perlu.
    }
};
