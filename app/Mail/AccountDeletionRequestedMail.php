<?php

namespace App\Mail;

use App\Models\AccountDeleteRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountDeletionRequestedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $deleteRequest;
    public $mail_subject;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, AccountDeleteRequest $deleteRequest, string $subject)
    {
        $this->user = $user;
        $this->deleteRequest = $deleteRequest;
        $this->mail_subject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mail_subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.account_deletion_requested',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
