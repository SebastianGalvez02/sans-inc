<?php

namespace App\Services\Interfaces;

use App\DTOs\ProductResponseDto;
use Illuminate\Support\Collection;

/**
 * Interfaz para definir operaciones de negocio de productos.
 *
 * Establece el contrato que debe cumplir el servicio encargado de
 * preparar productos activos para las respuestas de la API.
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
interface IProductService
{
    /**
     * Realiza el listado de productos disponibles.
     *
     * @return Collection<int, ProductResponseDto>
     */
    public function listAvailableProducts(): Collection;

    /**
     * Obtiene un producto activo para resenia.
     *
     * @param int $id
     * @return ProductResponseDto
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getProductForReview(int $id): ProductResponseDto;

    /**
     * Realiza el listado de productos activos por categoria.
     *
     * @param int $categoryId
     * @return Collection<int, ProductResponseDto>
     */
    public function listProductsByCategory(int $categoryId): Collection;
}
