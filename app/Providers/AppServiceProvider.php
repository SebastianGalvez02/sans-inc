<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\IAgendaRepository;
use App\Repositories\Eloquent\AgendaRepository;
use App\Services\Interfaces\IAgendaService;
use App\Services\AgendaService;

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
            IAgendaRepository::class,
            AgendaRepository::class
        );
        $this->app->bind(
            IAgendaService::class,
            AgendaService::class
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
