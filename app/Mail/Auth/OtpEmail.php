<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected string $name;

    protected string $otp;
    public function __construct($name, $otp)
    {
        $this->otp = $otp;
        $this->name = $name;
    }
    public function build(): self
    {

        return $this->view('emails.otp', [
            'name' => $this->name,
            'otp' => $this->otp
        ]);
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appeto Verification Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
