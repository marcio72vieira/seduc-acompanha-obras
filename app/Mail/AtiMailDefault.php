<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AtiMailDefault extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly string $nameView, 
        private readonly array  $data, 
        private readonly string $subjectText)
    {
    }

    public function builld(): self
    {
        return $this->subject($this->subjectText)
        ->markdown("emails.{$this->nameView}", ['data' => $this->data]);
    }


    public function attachments(): array
    {
        return [];
    }

}