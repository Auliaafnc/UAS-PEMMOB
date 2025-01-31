<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Task;
use App\Observers\OrderObserver;
use App\Observers\TaskObserver;
use App\Policies\ActivityPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Activity::class, ActivityPolicy::class);

        // Register the observer
        Order::observe(OrderObserver::class);

        Task::observe(TaskObserver::class);
    }
}
