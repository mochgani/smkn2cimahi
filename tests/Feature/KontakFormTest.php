<?php

namespace Tests\Feature;

use App\Mail\PesanKontakMail;
use App\Models\Pesan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class KontakFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_submit_valid_form_simpan_ke_db(): void
    {
        Mail::fake();

        $payload = [
            'nama'    => 'Budi Santoso',
            'email'   => 'budi@example.com',
            'telepon' => '081234567890',
            'subjek'  => 'ppdb',
            'pesan'   => 'Saya ingin tanya tentang pendaftaran.',
        ];

        $response = $this->post('/kontak', $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pesans', [
            'nama'    => 'Budi Santoso',
            'email'   => 'budi@example.com',
            'topik'   => 'ppdb',
        ]);

        // Email notifikasi terkirim
        Mail::assertSent(PesanKontakMail::class);
    }

    public function test_submit_form_invalid_return_validation_error(): void
    {
        $response = $this->post('/kontak', [
            'nama'   => 'A', // terlalu pendek
            'email'  => 'bukan-email',
            'subjek' => 'invalid-topic',
            'pesan'  => 'pendek',
        ]);

        $response->assertSessionHasErrors(['nama', 'email', 'subjek', 'pesan']);
        $this->assertSame(0, Pesan::count());
    }

    public function test_submit_form_kosong_return_validation_error(): void
    {
        $response = $this->post('/kontak', []);

        $response->assertSessionHasErrors(['nama', 'email', 'subjek', 'pesan']);
    }

    public function test_email_tidak_valid_ditolak(): void
    {
        $response = $this->post('/kontak', [
            'nama'   => 'Test User',
            'email'  => 'invalid-email-format',
            'subjek' => 'ppdb',
            'pesan'  => 'Ini pesan yang valid lebih dari 10 karakter.',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_subjek_di_luar_whitelist_ditolak(): void
    {
        $response = $this->post('/kontak', [
            'nama'   => 'Test User',
            'email'  => 'test@example.com',
            'subjek' => 'hacker-attempt',
            'pesan'  => 'Ini pesan yang valid lebih dari 10 karakter.',
        ]);

        $response->assertSessionHasErrors(['subjek']);
    }
}
