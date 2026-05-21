<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Kontak Baru</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #0a0a0a; background: #fafaf8; padding: 20px; margin: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 32px; border: 1px solid #d4d0c5; }
        .header { padding-bottom: 16px; border-bottom: 2px solid #0d6e3f; margin-bottom: 24px; }
        .header h1 { color: #0d6e3f; font-size: 18px; margin: 0; letter-spacing: 0.05em; text-transform: uppercase; font-family: 'JetBrains Mono', monospace; }
        .header p { color: #6b6b66; font-size: 13px; margin: 4px 0 0; }
        .field { margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #e8e6e0; }
        .field:last-of-type { border-bottom: none; }
        .label { font-size: 11px; color: #6b6b66; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 4px; font-family: 'JetBrains Mono', monospace; }
        .value { font-size: 15px; color: #0a0a0a; word-break: break-word; }
        .value a { color: #0d6e3f; }
        .pesan { background: #f4f2ec; padding: 16px; border-left: 3px solid #0d6e3f; white-space: pre-wrap; }
        .footer { margin-top: 32px; padding-top: 16px; border-top: 1px solid #e8e6e0; font-size: 11px; color: #6b6b66; font-family: 'JetBrains Mono', monospace; line-height: 1.6; }
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

        @if ($pesan->telepon)
            <div class="field">
                <div class="label">Telepon</div>
                <div class="value">{{ $pesan->telepon }}</div>
            </div>
        @endif

        <div class="field">
            <div class="label">Topik</div>
            <div class="value">{{ \Illuminate\Support\Str::title(str_replace('-', ' ', $pesan->topik)) }}</div>
        </div>

        <div class="field">
            <div class="label">Pesan</div>
            <div class="value pesan">{{ $pesan->pesan }}</div>
        </div>

        <div class="footer">
            Diterima: {{ $pesan->created_at->locale('id')->translatedFormat('d F Y, H:i') }} WIB<br>
            IP Address: {{ $pesan->ip_address ?? '—' }}<br><br>
            Reply ke email pengirim langsung dari email ini (Reply-To sudah di-set).
        </div>
    </div>
</body>
</html>
