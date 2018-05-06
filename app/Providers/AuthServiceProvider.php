<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Auth; 
use App\Services\Auth\Dmobi;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('dmobi', function($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...
            return new Dmobi(Auth::createUserProvider($config['provider']));
        });
    }
}
