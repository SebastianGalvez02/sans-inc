<?php

namespace App\Providers;

use App\Repositories\Eloquent\AgendaRepository;
use App\Repositories\Interfaces\IAgendaRepository;
use App\Services\AgendaService;
use App\Services\Interfaces\IAgendaService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
{
    $this->app->bind(IAgendaRepository::class, AgendaRepository::class);
    $this->app->bind(IAgendaService::class, AgendaService::class);
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
