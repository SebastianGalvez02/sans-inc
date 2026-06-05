<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Interfaces\IProductRepository::class,
            \App\Repositories\Implements\ProductRepository::class
        );

        $this->app->bind(
            \App\Services\Interfaces\IProductService::class,
            \App\Services\Implements\ProductService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
