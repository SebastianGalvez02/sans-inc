<?php

namespace App\Services\Implements;

use App\DTOs\ProductResponseDto;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Interfaces\IProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class ProductService implements IProductService
{
    protected IProductRepository $productRepository;

    /**
     * ProductService constructor.
     *
     * @param IProductRepository $productRepository
     */
    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * List all available (active) products.
     *
     * @return Collection<int, ProductResponseDto>
     */
    public function listAvailableProducts(): Collection
    {
        $products = $this->productRepository->getAllActive();

        return $products->map(fn($product) => ProductResponseDto::fromModel($product));
    }

    /**
     * Get an active product for review.
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
     * List active products by category ID.
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
