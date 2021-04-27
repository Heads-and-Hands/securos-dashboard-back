<?php

namespace App\Providers;

use App\Dashboard\Auth\DashboardGuard;
use App\Dashboard\Auth\DashboardUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Added Auth begin
        /*
        Auth::extend('dashboard', function ($app, $name, array $config) {
            return new DashboardGuard(Auth::createUserProvider($config['provider']));
        });
        Auth::provider('dashboard', function ($app, array $config) {
            return new DashboardUserProvider();
        });
        */
        // Added Auth end
    }
}
