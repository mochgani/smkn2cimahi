# Fase 8: Form Kontak dengan Email Notification

Estimasi: ~1 jam

## 1. Buat Form Request untuk Validation

```bash
php artisan make:request StorePesanRequest
```

Edit `app/Http/Requests/StorePesanRequest.php`:

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePesanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'telepon' => ['nullable', 'string', 'max:20'],
            'topik' => ['required', 'string', 'in:ppdb,bkk,kemitraan,alumni,kunjungan,lain'],
            'pesan' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi',
            'nama.min' => 'Nama minimal 3 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'topik.required' => 'Pilih topik pesan',
            'topik.in' => 'Topik tidak valid',
            'pesan.required' => 'Pesan tidak boleh kosong',
            'pesan.min' => 'Pesan minimal 10 karakter',
            'pesan.max' => 'Pesan maksimal 2000 karakter',
        ];
    }
}
```

## 2. Buat Mailable

```bash
php artisan make:mail PesanKontakMail
```

Edit `app/Mail/PesanKontakMail.php`:

```php
<?php

namespace App\Mail;

use App\Models\Pesan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PesanKontakMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pesan $pesan)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[Kontak Web] {$this->pesan->topik} — {$this->pesan->nama}",
            replyTo: [
                new Address($this->pesan->email, $this->pesan->nama),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pesan-kontak',
            with: ['pesan' => $this->pesan],
        );
    }
}
```

## 3. Buat Email Template

Buat file `resources/views/emails/pesan-kontak.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Kontak Baru</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #0a0a0a; background: #fafaf8; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 32px; border: 1px solid #d4d0c5; }
        .header { padding-bottom: 16px; border-bottom: 2px solid #0d6e3f; margin-bottom: 24px; }
        .header h1 { color: #0d6e3f; font-size: 18px; margin: 0; letter-spacing: 0.05em; text-transform: uppercase; }
        .header p { color: #6b6b66; font-size: 13px; margin: 4px 0 0; }
        .field { margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #e8e6e0; }
        .field:last-child { border-bottom: none; }
        .label { font-size: 11px; color: #6b6b66; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 4px; font-family: monospace; }
        .value { font-size: 15px; color: #0a0a0a; word-break: break-word; }
        .pesan { background: #f4f2ec; padding: 16px; border-left: 3px solid #0d6e3f; white-space: pre-wrap; }
        .footer { margin-top: 32px; padding-top: 16px; border-top: 1px solid #e8e6e0; font-size: 11px; color: #6b6b66; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pesan Kontak Baru</h1>
            <p>Diterima dari formulir kontak website SMKN 2 Cimahi</p>
        </div>

        <div class="field">
            <div class="label">Nama</div>
            <div class="value">{{ $pesan->nama }}</div>
        </div>

        <div class="field">
            <div class="label">Email</div>
            <div class="value"><a href="mailto:{{ $pesan->email }}">{{ $pesan->email }}</a></div>
        </div>

        @if($pesan->telepon)
        <div class="field">
            <div class="label">Telepon</div>
            <div class="value">{{ $pesan->telepon }}</div>
        </div>
        @endif

        <div class="field">
            <div class="label">Topik</div>
            <div class="value">{{ ucwords(str_replace('-', ' ', $pesan->topik)) }}</div>
        </div>

        <div class="field">
            <div class="label">Pesan</div>
            <div class="value pesan">{{ $pesan->pesan }}</div>
        </div>

        <div class="footer">
            Diterima: {{ $pesan->created_at->translatedFormat('d F Y, H:i') }} WIB<br>
            IP Address: {{ $pesan->ip_address }}<br><br>
            Reply ke email pengirim langsung dari email ini.
        </div>
    </div>
</body>
</html>
```

## 4. Konfigurasi SMTP di `.env`

### Untuk Development (log)
```env
MAIL_MAILER=log
```
Email akan tersimpan di `storage/logs/laravel.log`.

### Untuk Production (Gmail SMTP example)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=info@smkn2cmi.sch.id
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@smkn2cmi.sch.id"
MAIL_FROM_NAME="${APP_NAME}"
```

> **Note**: Untuk Gmail, gunakan App Password, bukan password biasa. Setting di Google Account > Security > 2-Step Verification > App Passwords.

### Alternative: Resend (recommended untuk production)
```bash
composer require resend/resend-laravel
```

```env
MAIL_MAILER=resend
RESEND_KEY=re_xxxxxxxxxxxx
```

## 5. Update Vue Form Page (Kontak.vue)

```vue
<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue';
import { useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    nama: '',
    email: '',
    telepon: '',
    topik: '',
    pesan: '',
});

const success = ref(false);

const submit = () => {
    form.post(route('kontak.store'), {
        onSuccess: () => {
            success.value = true;
            form.reset();
            setTimeout(() => success.value = false, 5000);
        },
    });
};
</script>

<template>
    <Head title="Kontak" />
    
    <AppLayout>
        <!-- Page header & info cards -->
        <!-- ... existing content ... -->

        <!-- Form section -->
        <form @submit.prevent="submit" class="kontak-form">
            <div class="form-header">
                <div class="form-label">KIRIM PESAN</div>
                <h3 class="form-title">Tulis pesan Anda</h3>
                <p class="form-sub">Kami akan merespon dalam 1×24 jam kerja.</p>
            </div>

            <!-- Success message -->
            <div v-if="success" class="bg-accent/10 border border-accent text-accent p-4 mb-4">
                ✓ Pesan Anda telah terkirim. Kami akan merespon dalam 1×24 jam.
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-input-label">Nama Lengkap *</label>
                    <input 
                        v-model="form.nama" 
                        type="text" 
                        class="form-input"
                        :class="{ 'border-red-500': form.errors.nama }"
                        placeholder="Nama Anda" 
                        required
                    >
                    <p v-if="form.errors.nama" class="text-xs text-red-500 mt-1">{{ form.errors.nama }}</p>
                </div>

                <div class="form-group">
                    <label class="form-input-label">Email *</label>
                    <input 
                        v-model="form.email" 
                        type="email" 
                        class="form-input"
                        :class="{ 'border-red-500': form.errors.email }"
                        placeholder="email@anda.com" 
                        required
                    >
                    <p v-if="form.errors.email" class="text-xs text-red-500 mt-1">{{ form.errors.email }}</p>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-input-label">No. Telepon</label>
                    <input v-model="form.telepon" type="tel" class="form-input" placeholder="+62 ...">
                </div>

                <div class="form-group">
                    <label class="form-input-label">Topik *</label>
                    <select v-model="form.topik" class="form-input" required>
                        <option value="">Pilih topik</option>
                        <option value="ppdb">Penerimaan Murid Baru (SPMB)</option>
                        <option value="bkk">Kerja Sama Industri / BKK</option>
                        <option value="kemitraan">Kemitraan IDUKA</option>
                        <option value="alumni">Informasi Alumni</option>
                        <option value="kunjungan">Kunjungan Sekolah</option>
                        <option value="lain">Lainnya</option>
                    </select>
                </div>
            </div>

            <div class="form-group form-group-full">
                <label class="form-input-label">Pesan *</label>
                <textarea 
                    v-model="form.pesan" 
                    class="form-input form-textarea"
                    placeholder="Tulis pesan Anda di sini..." 
                    rows="6" 
                    required
                ></textarea>
                <p v-if="form.errors.pesan" class="text-xs text-red-500 mt-1">{{ form.errors.pesan }}</p>
            </div>

            <div class="form-footer">
                <p class="form-note">* Wajib diisi. Data Anda akan dijaga kerahasiaannya.</p>
                <button 
                    type="submit" 
                    class="form-submit"
                    :disabled="form.processing"
                >
                    <span v-if="!form.processing">Kirim Pesan →</span>
                    <span v-else>Mengirim...</span>
                </button>
            </div>
        </form>
    </AppLayout>
</template>
```

## 6. Test Form

1. Akses `http://localhost:8000/kontak`
2. Isi form dan submit
3. Cek di admin panel `/admin` → Inbox > Pesan Kontak
4. Cek `storage/logs/laravel.log` untuk lihat email yang dikirim

## 7. Optional: Rate Limiting

Untuk mencegah spam, tambah rate limiting di `routes/web.php`:

```php
Route::post('/kontak', [KontakController::class, 'store'])
    ->middleware('throttle:5,60')  // 5 request per 60 menit
    ->name('kontak.store');
```

## 8. Optional: Recaptcha v3

```bash
composer require google/recaptcha
```

Lihat dokumentasi Google reCAPTCHA untuk implementasi.

## ✅ Verifikasi Fase 8

- [ ] Form bisa submit
- [ ] Validation berjalan
- [ ] Pesan tersimpan di database
- [ ] Pesan muncul di admin panel
- [ ] Email notification terkirim (atau ter-log)
- [ ] Success message muncul setelah submit
- [ ] Error messages muncul jika validation gagal

## 🎉 Selesai!

Project Anda sekarang sudah:
- ✅ Laravel 13 + Inertia + Vue 3
- ✅ Tailwind CSS v3 dengan design tokens custom
- ✅ Database lengkap dengan models & relationships
- ✅ Filament v3 admin panel
- ✅ Form kontak dengan email notification
- ✅ 14 halaman fully functional

## 📦 Next Steps (Optional Enhancements)

1. **SEO**: Setup meta tags per halaman, Open Graph, sitemap.xml
2. **Search**: Tambah pencarian berita dengan Laravel Scout + Meilisearch
3. **Image optimization**: Spatie Media Library untuk handle gambar
4. **Caching**: Redis untuk cache query yang berat
5. **Deployment**: Deploy ke Forge, Ploi, atau VPS dengan Cloudflare
6. **Analytics**: Google Analytics 4 atau Plausible
7. **Backup**: Spatie Laravel Backup untuk auto-backup database
8. **PWA**: Progressive Web App untuk offline access
9. **Multi-language**: Tambah bahasa Inggris dengan Laravel localization

---

🎓 **Selamat! Website SMKN 2 Cimahi siap deploy.**
