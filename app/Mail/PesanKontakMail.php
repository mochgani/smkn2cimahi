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
