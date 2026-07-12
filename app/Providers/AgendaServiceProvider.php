<?php

namespace App\Providers;

use App\Repositories\Eloquent\AgendaRepository;
use App\Repositories\Interfaces\IAgendaRepository;
use App\Services\AgendaService;
use App\Services\Interfaces\IAgendaService;
use Illuminate\Support\ServiceProvider;

/**
 * AgendaServiceProvider
 * Registers the bindings for the Agenda module.
 * Keeps agenda-specific bindings isolated from AppServiceProvider.
 */
class AgendaServiceProvider extends ServiceProvider
{
    /**
     * Register agenda interface bindings into the service container.
     */
    public function register(): void
    {
        $this->app->bind(IAgendaRepository::class, AgendaRepository::class);
        $this->app->bind(IAgendaService::class, AgendaService::class);
    }

    /**
     * Bootstrap any agenda services.
     */
    public function boot(): void
    {
        //
    }
}