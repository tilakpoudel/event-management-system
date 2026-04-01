<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Event;
use App\Models\Booking;
use App\Policies\EventPolicy;
use App\Policies\BookingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Event::class => EventPolicy::class,
        Booking::class => BookingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
