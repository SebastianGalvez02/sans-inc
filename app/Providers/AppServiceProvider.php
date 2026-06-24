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

        $this->app->bind(
            \App\Repositories\Interfaces\ICategoryRepository::class,
            \App\Repositories\Implements\CategoryRepository::class
        );

        $this->app->bind(
            \App\Services\Interfaces\ICategoryService::class,
            \App\Services\Implements\CategoryService::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\IPublicationRepository::class,
            \App\Repositories\Implements\PublicationRepository::class
        );

        $this->app->bind(
            \App\Services\Interfaces\IPublicationService::class,
            \App\Services\Implements\PublicationService::class
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
