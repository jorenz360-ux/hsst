<?php

namespace App\Mail;

use App\Models\Staff;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffAccountApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Staff $staff,
        public readonly string $username,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your HSST Reunion Account Has Been Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.staff-account-approved',
        );
    }
}
