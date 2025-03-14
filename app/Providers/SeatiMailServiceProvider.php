<?php

namespace App\Providers;

use App\SeatiMail\SeatiMailManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\MailServiceProvider;

class SeatiMailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected function registerIlluminateMailer()
    {
        $this->app->singleton('mail.manager', function ($app) {
            return new SeatiMailManager($app);
        });

        // Copied from Illuminate\Mail\MailServiceProvider
        $this->app->bind('mailer', function ($app) {
            return $app->make('mail.manager')->mailer();
        });
    }
}
