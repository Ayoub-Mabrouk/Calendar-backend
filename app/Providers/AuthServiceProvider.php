<?php

namespace App\Providers;

use App\Models\Calendar;
use App\Models\Event;
use App\Models\User;
use App\Policies\CalendarPolicy;
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
        Gate::define('view-calendar', [CalendarPolicy::class, 'view']);
        Gate::define('delete-calendar', [CalendarPolicy::class, 'delete']);
        Gate::define('store-event', 'App\Models\EventPolicy@store');
        Gate::define('update-event', 'App\Models\EventPolicy@update');
        Gate::define('delete-event', 'App\Models\EventPolicy@delete');
    }
}
