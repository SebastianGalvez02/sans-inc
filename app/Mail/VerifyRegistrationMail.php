<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyRegistrationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $verificationUrl,
        public readonly string $name,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Confirma tu registro en Sans Inc');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.verify-registration');
    }
}
