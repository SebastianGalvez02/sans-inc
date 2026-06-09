<?php

namespace App\Repositories\Implements;

use App\Models\Category;
use App\Repositories\Interfaces\ICategoryRepository;
use Illuminate\Support\Collection;

class CategoryRepository implements ICategoryRepository
{
    public function getAll(): Collection
    {
        return Category::orderBy('categoryName')->get();
    }

    public function findById(int $id): ?Category
    {
        return Category::where('categoryId', $id)->first();
    }

    public function create(array $attributes): Category
    {
        return Category::create($attributes);
    }

    public function update(Category $category, array $attributes): Category
    {
        $category->update($attributes);

        return $category->refresh();
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
