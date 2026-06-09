<?php

namespace App\Services\Interfaces;

use App\DTOs\CategoryResponseDto;
use Illuminate\Support\Collection;

interface ICategoryService
{
    /**
     * @return Collection<int, CategoryResponseDto>
     */
    public function listCategories(): Collection;

    public function getCategory(int $id): CategoryResponseDto;

    public function createCategory(array $data): CategoryResponseDto;

    public function updateCategory(int $id, array $data): CategoryResponseDto;

    public function deleteCategory(int $id): void;
}
