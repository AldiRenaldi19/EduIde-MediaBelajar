<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Course;
use App\Models\Module;
use App\Models\User;
use App\Models\Review;
use App\Observers\AuditLogObserver;

class AuditServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Course::observe(AuditLogObserver::class);
        Module::observe(AuditLogObserver::class);
        User::observe(AuditLogObserver::class);
        Review::observe(AuditLogObserver::class);
    }
}
