<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\IAgendaRepository;
use App\Repositories\Eloquent\AgendaRepository;
use App\Services\Interfaces\IAgendaService;
use App\Services\AgendaService;

/**
 * Clase para registrar servicios de la aplicacion.
 *
 * Vincula interfaces con sus implementaciones, incluyendo los contratos
 * del modulo productos para repositorio y servicio.
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra los bindings de servicios y repositorios.
     */
    public function register(): void
    {
        /**
         * Binding para resolver consultas de productos.
         */
        $this->app->bind(
            \App\Repositories\Interfaces\IProductRepository::class,
            \App\Repositories\Implements\ProductRepository::class
        );

        /**
         * Binding para resolver la logica de negocio de productos.
         */
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
     * Inicializa servicios de la aplicacion.
     */
    public function boot(): void
    {
        //
    }
}
