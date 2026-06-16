<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use Illuminate\Support\Collection;

interface ICategoryRepository
{
    /**
     * @return Collection<int, Category>
     */
    public function getAll(): Collection;

    public function findById(int $id): ?Category;

    public function create(array $attributes): Category;

    public function update(Category $category, array $attributes): Category;

    public function delete(Category $category): void;
}
