<?php

namespace App\Providers;

use App\AtiMail\AtiMailManager;
use Illuminate\Mail\MailServiceProvider;

class AtiMailServiceProvider extends MailServiceProvider
{

    protected function registerIlluminateMailer()
    {
        $this->app->singleton('mail.manager', function ($app) {
            return new AtiMailManager($app);
        });

        // Copied from Illuminate\Mail\MailServiceProvider
        $this->app->bind('mailer', function ($app) {
            return $app->make('mail.manager')->mailer();
        });
    }
}
