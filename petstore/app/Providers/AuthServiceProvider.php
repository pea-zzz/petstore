<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        /* define a user role */ 
        Gate::define('isUser', function($user) { 
            return $user->role == 'user'; 
        }); 

        /* define an administrator user role */ 
        Gate::define('isAdmin', function($user) { 
            return $user->role == 'admin'; 
        }); 

        // Set the lifetime of the remember_token cookie (in minutes)
        Config::set('session.lifetime', 60 * 24 * 3); // 3 days
        Config::set('session.expire_on_close', false); // Do not log out immediately when the browser is closed


    }
}
