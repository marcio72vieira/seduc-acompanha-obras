<?php

namespace App\SeatiMail\Transport;

use Exception;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;
use Throwable;

class SeatiMailTransport extends AbstractTransport
{
    protected ClientInterface $client;

    protected string $key;

    protected string $url;

    public function __construct(ClientInterface $client, $url, $key)
    {
        $this->key = $key;
        $this->client = $client;
        $this->url = $url;

        parent::__construct();
    }

    private function headers(): array
    {
        return [
            'Authorization' => "Basic {$this->key}",
            'Content-Type' => 'application/json',
        ];
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
        $arquivos = $email->getAttachments();

        try {
            $anexos = $this->prepareAttachments($arquivos);

            $this->client->request('POST', $this->url, [
                'headers' => $this->headers(),
                'json' => [
                    'destinatarios' => collect($email->getTo())->map->toString()->values()->all(),
                    'assunto' => $email->getSubject(),
                    'corpo' => $email->getHtmlBody() ?? $email->getTextBody(),
                    'anexo' => $anexos,
                ],
            ]);
        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());
            throw new Exception(
                sprintf('A solicitação para a API da SEATI falhou. Razão: %s.', $throwable->getMessage()),
                is_int($throwable->getCode()) ? $throwable->getCode() : 0,
                $throwable
            );
        }
    }

    protected function prepareAttachments(array $attachments): array
    {
        $anexos = [];

        foreach ($attachments as $attachment) {
            $conteudo = $attachment->getMediaSubtype() === 'pdf'
                ? base64_encode(file_get_contents('files/'.$attachment->getName()))
                : base64_encode($attachment->getBody());

            $anexos[] = [
                'nome' => $attachment->getName(),
                'conteudo' => $conteudo,
            ];
        }

        return $anexos;
    }

    public function __toString(): string
    {
        return 'seatimail';
    }
}
