<?php

namespace App\Mail;

use App\Models\Staff;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StaffRegistrationPending extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Staff $staff,
        public readonly string $accountType,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Non-Alumni Registration Pending Approval',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.staff-registration-pending',
        );
    }
}
