<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Jury;
use App\Models\Team;
use App\Policies\JuryPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isCompetitor', function ($user) {
            return $user->isCompetitor();
        });

        Gate::define('isAdmin', function ($user) {
            return $user->isAdmin();
        });
    }
}
