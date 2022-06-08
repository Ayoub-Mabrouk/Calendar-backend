<?php

namespace App\Providers;

use App\Models\Calendar;
use App\Models\Event;
use App\Models\User;
use App\Policies\CalendarPolicy;
use App\Policies\EventPolicy;
use App\Policies\UserPolicy;
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
        Calendar::class => CalendarPolicy::class,
        Event::class => EventPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //calendar policy for user
        Gate::define('view-calendar', [CalendarPolicy::class, 'view']);
        Gate::define('create-calendar', [CalendarPolicy::class, 'create']);
        Gate::define('delete-calendar', [CalendarPolicy::class, 'delete']);
        Gate::define('update-calendar', [CalendarPolicy::class, 'update']);
        //event policy for user
        Gate::define('view-event', [EventPolicy::class, 'view']);
        Gate::define('create-event', [EventPolicy::class, 'create']);
        Gate::define('delete-event', [EventPolicy::class, 'delete']);
        Gate::define('update-event', [EventPolicy::class, 'update']);
    }
}
