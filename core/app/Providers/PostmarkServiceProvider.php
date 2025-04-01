<?php

namespace App\Providers;

use App\Mail\PostmarkTransport;
use Illuminate\Support\ServiceProvider;
use Postmark\PostmarkClient;

class PostmarkServiceProvider extends ServiceProvider
{
    /**
     * Register the Postmark Swift Transport driver.
     *
     * @return void
     */
    public function register()
    {
        $this->app->afterResolving('swift.transport', function ($manager) {
            $manager->extend('postmark', function () {
                $client = new PostmarkClient(
                    $this->app['config']->get('services.postmark.token')
                );

                return new PostmarkTransport(
                    $client,
                    $this->app['config']->get('services.postmark.token')
                );
            });
        });
    }
}
