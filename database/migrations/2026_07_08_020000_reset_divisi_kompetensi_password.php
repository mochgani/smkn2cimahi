<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Samakan password 10 akun Divisi & Kompetensi ke "@smkn2cmi" (sementara).
     * Catatan: password ini TIDAK memenuhi kebijakan password production
     * (butuh mixedCase + angka), jadi hanya bisa di-set langsung ke DB —
     * kalau nanti diedit ulang via form admin, harus diganti ke password
     * yang lebih kuat. Sebaiknya tiap akun ganti password setelah login.
     */
    private const EMAILS = [
        'kesiswaan@smkn2cmi.sch.id',
        'kurikulum@smkn2cmi.sch.id',
        'hubin@smkn2cmi.sch.id',
        'sarpras@smkn2cmi.sch.id',
        'animasi@smkn2cmi.sch.id',
        'dkv@smkn2cmi.sch.id',
        'rpl@smkn2cmi.sch.id',
        'kimia@smkn2cmi.sch.id',
        'mekatronika@smkn2cmi.sch.id',
        'pemesinan@smkn2cmi.sch.id',
    ];

    public function up(): void
    {
        User::whereIn('email', self::EMAILS)->update([
            'password' => Hash::make('@smkn2cmi'),
        ]);
    }

    public function down(): void
    {
        // Password lama tidak disimpan, tidak ada rollback.
    }
};
