<?php

namespace Tests\Feature;

use App\Models\BkkSetting;
use App\Models\KontakSetting;
use App\Models\ProfilKepalaSekolah;
use App\Models\ProfilSejarah;
use App\Models\ProfilVisiMisi;
use App\Models\SchoolSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SingletonModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_kontak_setting_instance_otomatis_dibuat(): void
    {
        $this->assertSame(0, KontakSetting::count());

        $kontak = KontakSetting::instance();

        $this->assertSame(1, KontakSetting::count());
        $this->assertSame(1, $kontak->id);
    }

    public function test_kontak_setting_instance_kembalikan_row_yang_sama(): void
    {
        $a = KontakSetting::instance();
        $b = KontakSetting::instance();

        $this->assertSame($a->id, $b->id);
        $this->assertSame(1, KontakSetting::count());
    }

    public function test_school_setting_instance_singleton(): void
    {
        SchoolSetting::instance();
        SchoolSetting::instance();
        SchoolSetting::instance();

        $this->assertSame(1, SchoolSetting::count());
    }

    public function test_profil_sejarah_singleton(): void
    {
        ProfilSejarah::instance();
        ProfilSejarah::instance();

        $this->assertSame(1, ProfilSejarah::count());
    }

    public function test_profil_visi_misi_singleton(): void
    {
        ProfilVisiMisi::instance();
        ProfilVisiMisi::instance();

        $this->assertSame(1, ProfilVisiMisi::count());
    }

    public function test_profil_kepala_sekolah_singleton(): void
    {
        ProfilKepalaSekolah::instance();
        ProfilKepalaSekolah::instance();

        $this->assertSame(1, ProfilKepalaSekolah::count());
    }

    public function test_bkk_setting_singleton(): void
    {
        BkkSetting::instance();
        BkkSetting::instance();

        $this->assertSame(1, BkkSetting::count());
    }

    public function test_school_setting_default_values_terisi(): void
    {
        $setting = SchoolSetting::instance();

        $this->assertNotNull($setting->school_name);
        $this->assertNotNull($setting->tagline);
        $this->assertNotNull($setting->tahun_berdiri);
    }
}
