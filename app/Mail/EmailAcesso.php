<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailAcesso extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    // $dados são enviados a partir do método store da classe UserController após salvar o "user"
    public function __construct(public readonly array $dados)
    {
        //dd($dados);
        //Obs: $dados é acessivel na view de email(admin.users.emailacesso), nativamente
        //     Não há a necessidade de se criar um variavel do tipo private $dados e atribuir seu valor com $this->dados = $dados.
        //     A nova função "promotion" do Php 8.3 faz isso de forma automática.
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('seduc@email.ma.gov.br', 'SEDUC'),
            subject: 'Credenciais de Acesso ao Sistema de Acompanhamento de Obras da SEDUC',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.users.mailacesso',
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
