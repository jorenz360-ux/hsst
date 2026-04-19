<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffAccountRejected extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $fullName,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'HSST Reunion Registration Update',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.staff-account-rejected',
        );
    }
}
