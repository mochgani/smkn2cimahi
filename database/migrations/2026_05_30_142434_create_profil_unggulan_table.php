<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profil_unggulan', function (Blueprint $table) {
            $table->id();
            $table->string('num', 4)->default('01');     // 01, 02, ...
            $table->string('tag', 60);                    // KELAS INDUSTRI, KEWIRAUSAHAAN, TEFA, dll
            $table->string('title');                       // BUMA School, Ayena Studio, dll
            $table->text('desc');
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'display_order'], 'profil_unggulan_active_order_idx');
        });

        // Seed default values dari hardcoded data lama
        DB::table('profil_unggulan')->insert([
            [
                'num' => '01', 'tag' => 'KELAS INDUSTRI', 'title' => 'BUMA School',
                'desc' => 'Kerja sama dengan PT Bukit Makmur Mandiri Utama (BUMA), perusahaan pertambangan batu bara untuk mempersiapkan lulusan siap kerja di industri tambang.',
                'display_order' => 1, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'num' => '02', 'tag' => 'KELAS INDUSTRI', 'title' => 'Ayena Studio',
                'desc' => 'Kolaborasi dengan studio animasi profesional untuk pengembangan kompetensi siswa di industri animasi dan kreatif.',
                'display_order' => 2, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'num' => '03', 'tag' => 'KEWIRAUSAHAAN', 'title' => 'Cimahi Markerspace',
                'desc' => 'Program kewirausahaan digital di bidang desain yang membentuk siswa menjadi wirausahawan kreatif dan mandiri.',
                'display_order' => 3, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'num' => '04', 'tag' => 'TEFA', 'title' => 'Teaching Factory',
                'desc' => 'Sistem pembelajaran berbasis produksi dan simulasi dunia kerja, memberikan pengalaman langsung kepada siswa layaknya bekerja di industri sungguhan.',
                'display_order' => 4, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_unggulan');
    }
};
