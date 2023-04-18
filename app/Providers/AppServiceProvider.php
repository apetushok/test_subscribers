<?php

namespace App\Providers;

use App\Services\SubscribersService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use MailerLite\MailerLite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Event::listen('Illuminate\Auth\Events\Authenticated', function ($authenticated) {
            $this->app->bind(SubscribersService::class, function () use ($authenticated) {
                return new SubscribersService(
                    new MailerLite(['api_key' => $authenticated->user->mailer_lite_api_key ?? null])
                );
            });
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
