<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CloudinaryClient;

// Cloudinary SDK
use Cloudinary\Cloudinary;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind CloudinaryClient for DI and testing
        $this->app->singleton(CloudinaryClient::class, function ($app) {
            $cloud = new Cloudinary(env('CLOUDINARY_URL'));
            return new CloudinaryClient($cloud);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
