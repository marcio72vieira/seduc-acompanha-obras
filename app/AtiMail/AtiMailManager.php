<?php

namespace App\AtiMail;

use App\AtiMail\Transport\AtiMailTransport;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Mail\MailManager;
use Illuminate\Support\Arr;

class AtiMailManager extends MailManager
{
    protected function createAtiMailTransport()
    {
        $config = $this->app['config']->get('services.atimail', []);

        return new AtiMailTransport(
            $this->guzzle($config),
            $config['url'],
            $config['key'],
        );
    }

    /**
     * Get a fresh Guzzle HTTP client instance.
     *
     * @return \GuzzleHttp\Client
     */
    protected function guzzle(array $config)
    {
        return new HttpClient(Arr::add(
            $config['guzzle'] ?? [],
            'connect_timeout',
            300
        ));
    }
}
