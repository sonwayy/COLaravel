<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Event;
use App\Policies\EventPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Event::class => EventPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Password::defaults(fn () =>
            Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()
        );

        // Define gate for update-event
        Gate::define('update-event', function ($user, $event) {
           return $user->id === $event->organizer;
        });

        // Define gate for delete-event
        Gate::define('delete-event', function ($user, $event) {
            return $user->id === $event->organizer;
        });

        // Define gate for edit-event
        Gate::define('edit-event', function ($user, $event) {
            return $user->id === $event->organizer;
        });


    }
}
