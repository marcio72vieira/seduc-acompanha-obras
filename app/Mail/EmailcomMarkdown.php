<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailcomMarkdown extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly array $dados)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('seduc@email.ma.gov.br', 'SEDUC'),
            subject: 'Informações de Cadastro',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.emailcommarkdown',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
