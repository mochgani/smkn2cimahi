<?php

namespace Tests\Feature;

use App\Models\Berita;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BeritaScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_scope_hanya_return_yang_approved(): void
    {
        Berita::factory()->create(['is_published' => true, 'approval_status' => 'approved']);
        Berita::factory()->create(['is_published' => true, 'approval_status' => 'pending']);
        Berita::factory()->create(['is_published' => true, 'approval_status' => 'rejected']);
        Berita::factory()->create(['is_published' => false, 'approval_status' => 'approved']);

        $this->assertSame(1, Berita::published()->count());
    }

    public function test_published_scope_exclude_future_published_at(): void
    {
        Berita::factory()->create([
            'is_published'    => true,
            'approval_status' => 'approved',
            'published_at'    => now()->subDay(),
        ]);
        Berita::factory()->create([
            'is_published'    => true,
            'approval_status' => 'approved',
            'published_at'    => now()->addDay(), // future, scheduled
        ]);

        $this->assertSame(1, Berita::published()->count());
    }

    public function test_published_scope_exclude_pending_dan_rejected(): void
    {
        Berita::factory()->pending()->create(['is_published' => true]);
        Berita::factory()->rejected()->create(['is_published' => true]);

        $this->assertSame(0, Berita::published()->count());
    }

    public function test_featured_scope_hanya_return_is_featured_true(): void
    {
        Berita::factory()->featured()->create();
        Berita::factory()->create(['is_featured' => false]);
        Berita::factory()->create(['is_featured' => false]);

        $this->assertSame(1, Berita::featured()->count());
    }
}
