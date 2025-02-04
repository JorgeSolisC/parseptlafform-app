<?php

namespace App\Providers;

use App\Services\ParseLiveQueryClient;
use Illuminate\Support\ServiceProvider;
use Parse\ParseClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ParseClient::initialize(
            config('services.parse.app_id'),
            config('services.parse.rest_key'),
            config('services.parse.master_key')
        );
        ParseClient::setServerURL(config('services.parse.server_url'), '/');
    }
}
