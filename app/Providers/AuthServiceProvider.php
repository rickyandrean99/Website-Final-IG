<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('peserta', function($user) {
            return ($user->role == 'peserta') ? Response::allow() : Response::deny('No Access');
        });

        Gate::define('upgrade', function($user) {
            return ($user->role == 'upgrade' || $user->role == 'administrator') ? Response::allow() : Response::deny('No Access');
        });

        Gate::define('pasar', function($user) {
            return ($user->role == 'pasar' || $user->role == 'administrator') ? Response::allow() : Response::deny('No Access');
        });

        Gate::define('acara', function($user) {
            return ($user->role == 'acara' || $user->role == 'administrator') ? Response::allow() : Response::deny('No Access');
        });

        Gate::define('superadmin', function($user) {
            return ($user->role == 'administrator') ? Response::allow() : Response::deny('No Access');
        });

        Gate::define('panitia', function($user) {
            return ($user->role != 'peserta') ? Response::allow() : Response::deny('No Access');
        });
    }
}