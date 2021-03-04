<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Custom\SecurosRestApi;

class SecurosApiProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Custom\Contracts\SecurosAPI', function ($app) {
            return new SecurosRestApi();
        });
    }
}
