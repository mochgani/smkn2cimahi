<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah index untuk kolom yang sering di-query (where, orderBy)
 * di tabel berita, kompetensi, dan tabel terkait lainnya.
 *
 * Catatan: kolom `slug` di kompetensi sudah unique, jadi sudah berindex.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Komposit untuk Berita::published()
            $table->index(['is_published', 'approval_status', 'published_at'], 'beritas_published_idx');

            // Untuk scoped query per divisi/kompetensi
            $table->index('kompetensi_id', 'beritas_kompetensi_idx');
            $table->index('divisi_id', 'beritas_divisi_idx');

            // Untuk filter featured + sort tanggal
            $table->index(['is_featured', 'published_at'], 'beritas_featured_idx');
        });

        Schema::table('hero_banners', function (Blueprint $table) {
            $table->index(['is_active', 'display_order'], 'hero_banners_active_order_idx');
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->index(['parent_id', 'is_active', 'display_order'], 'menu_items_tree_idx');
        });

        Schema::table('school_stats', function (Blueprint $table) {
            $table->index(['is_active', 'display_order'], 'school_stats_active_order_idx');
        });

        Schema::table('rekap_siswa', function (Blueprint $table) {
            $table->index('kompetensi_id', 'rekap_siswa_kompetensi_idx');
        });

        Schema::table('pesans', function (Blueprint $table) {
            $table->index(['is_read', 'created_at'], 'pesans_read_idx');
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropIndex('beritas_published_idx');
            $table->dropIndex('beritas_kompetensi_idx');
            $table->dropIndex('beritas_divisi_idx');
            $table->dropIndex('beritas_featured_idx');
        });

        Schema::table('hero_banners', function (Blueprint $table) {
            $table->dropIndex('hero_banners_active_order_idx');
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropIndex('menu_items_tree_idx');
        });

        Schema::table('school_stats', function (Blueprint $table) {
            $table->dropIndex('school_stats_active_order_idx');
        });

        Schema::table('rekap_siswa', function (Blueprint $table) {
            $table->dropIndex('rekap_siswa_kompetensi_idx');
        });

        Schema::table('pesans', function (Blueprint $table) {
            $table->dropIndex('pesans_read_idx');
        });
    }
};
