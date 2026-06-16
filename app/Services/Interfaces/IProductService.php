<?php

namespace App\Services\Interfaces;

use App\DTOs\ProductResponseDto;
use Illuminate\Support\Collection;

interface IProductService
{
    /**
     * List all available (active) products.
     *
     * @return Collection<int, ProductResponseDto>
     */
    public function listAvailableProducts(): Collection;

    /**
     * Get an active product for review.
     *
     * @param int $id
     * @return ProductResponseDto
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getProductForReview(int $id): ProductResponseDto;

    /**
     * List active products by category ID.
     *
     * @param int $categoryId
     * @return Collection<int, ProductResponseDto>
     */
    public function listProductsByCategory(int $categoryId): Collection;
}
