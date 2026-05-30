<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutoAssignCreatorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedRoles();
    }

    public function test_created_by_terisi_otomatis_dari_user_login(): void
    {
        // Logic ini ada di CreateBerita::mutateFormDataBeforeCreate
        $user = User::factory()->create();
        $user->assignRole('super_admin');

        // Simulasi: berita create dengan created_by dari user yang login
        $berita = Berita::factory()->create([
            'created_by' => $user->id,
        ]);

        $this->assertSame($user->id, $berita->created_by);
        $this->assertSame($user->name, $berita->creator->name);
    }

    public function test_relasi_creator_kembalikan_user_object(): void
    {
        $user = User::factory()->create(['name' => 'Test Author']);
        $berita = Berita::factory()->create(['created_by' => $user->id]);

        $this->assertNotNull($berita->creator);
        $this->assertInstanceOf(User::class, $berita->creator);
        $this->assertSame('Test Author', $berita->creator->name);
    }

    public function test_creator_null_jika_created_by_null(): void
    {
        $berita = Berita::factory()->create(['created_by' => null]);

        $this->assertNull($berita->creator);
    }
}
