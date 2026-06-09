<?php

namespace App\Services\Implements;

use App\DTOs\CategoryResponseDto;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Services\Interfaces\ICategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class CategoryService implements ICategoryService
{
    public function __construct(
        protected ICategoryRepository $categoryRepository
    ) {}

    public function listCategories(): Collection
    {
        return $this->categoryRepository
            ->getAll()
            ->map(fn($category) => CategoryResponseDto::fromModel($category));
    }

    public function getCategory(int $id): CategoryResponseDto
    {
        return CategoryResponseDto::fromModel($this->findCategoryOrFail($id));
    }

    public function createCategory(array $data): CategoryResponseDto
    {
        $category = $this->categoryRepository->create($this->toModelAttributes($data));

        return CategoryResponseDto::fromModel($category);
    }

    public function updateCategory(int $id, array $data): CategoryResponseDto
    {
        $category = $this->categoryRepository->update(
            $this->findCategoryOrFail($id),
            $this->toModelAttributes($data)
        );

        return CategoryResponseDto::fromModel($category);
    }

    public function deleteCategory(int $id): void
    {
        $this->categoryRepository->delete($this->findCategoryOrFail($id));
    }

    private function findCategoryOrFail(int $id)
    {
        $category = $this->categoryRepository->findById($id);

        if (!$category) {
            throw new ModelNotFoundException('Category not found.');
        }

        return $category;
    }

    private function toModelAttributes(array $data): array
    {
        return [
            'categoryName' => $data['name'],
            'categoryDescription' => $data['description'] ?? null,
        ];
    }
}
