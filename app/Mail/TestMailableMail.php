<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class TestMailableMail extends Mailable{
    use Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Mailable',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.test',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
