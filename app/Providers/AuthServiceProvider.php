<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
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
        // Gate de protection : Uniquement les utilisateurs connectés et faisant parti du G1 peuvent accéder

        Gate::define('annonce-access', function (User $user) {
            return in_array($user->group_id, [1, 3]);
        });

        Gate::define('task-access', function (User $user) {
            if (Auth::user()->annonces->count() > 0)
                return in_array($user->group_id, [2, 3]);
        });
    }
}
