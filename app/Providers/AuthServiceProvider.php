<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

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
    public function boot(GateContract $gate)
    {

        $this->registerPolicies($gate);

        $gate->define('isAdmin', function ($user) {
            return $user->type == 'admin';
        });

        $gate->define('isUser', function ($user) {
            return $user->type == 'user';
        });
        $gate->define('isDeveloper', function ($user) {
            return $user->type == 'developer';
        });

        $gate->define('isOrganization', function ($user) {
            return $user->type == 'organization';
        });

        $gate->define('isMyAccount', function ($user, $profileUser) {
            return $user->id === $profileUser->id;
        });



        Passport::routes();

        //
    }
}
