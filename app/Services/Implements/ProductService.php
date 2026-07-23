<?php

namespace App\Services\Implements;

use App\DTOs\ProductResponseDto;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Interfaces\IProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

/**
 * Clase para procesar la logica de negocio de productos.
 *
 * Coordina las consultas del repositorio y transforma los modelos
 * Product en DTOs de respuesta para la API.
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
class ProductService implements IProductService
{
    protected IProductRepository $productRepository;

    /**
     * Inicializa el servicio con el repositorio de productos.
     *
     * @param IProductRepository $productRepository
     */
    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Realiza el listado de productos disponibles.
     *
     * @return Collection<int, ProductResponseDto>
     */
    public function listAvailableProducts(): Collection
    {
        $products = $this->productRepository->getAllActive();

        return $products->map(fn($product) => ProductResponseDto::fromModel($product));
    }

    /**
     * Obtiene un producto activo para resenia.
     *
     * @param int $id
     * @return ProductResponseDto
     * @throws ModelNotFoundException
     */
    public function getProductForReview(int $id): ProductResponseDto
    {
        $product = $this->productRepository->findActiveById($id);

        if (!$product) {
            throw new ModelNotFoundException("Product not found or is inactive.");
        }

        return ProductResponseDto::fromModel($product);
    }

    /**
     * Realiza el listado de productos activos por categoria.
     *
     * @param int $categoryId
     * @return Collection<int, ProductResponseDto>
     */
    public function listProductsByCategory(int $categoryId): Collection
    {
        $products = $this->productRepository->getByCategoryId($categoryId);

        return $products->map(fn($product) => ProductResponseDto::fromModel($product));
    }
}
