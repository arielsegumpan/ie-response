<?php

namespace App\Mail\Responder;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VolunteerWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $temporaryPassword;
    public $role;
    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $temporaryPassword, $role, $token)
    {
        $this->name = $name;
        $this->temporaryPassword = $temporaryPassword;
        $this->role = $role;
        $this->token = $token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '👋 Welcome to IE-Response — Your Journey Begins Here!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'responder.volunteer.welcome-mail',
            with: [
                'name' => $this->name,
                'temporaryPassword' => $this->temporaryPassword,
                'role' => $this->role,
                // 'resetUrl' => url(config('app.url').route('password.reset', $this->token, false)),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
