<?php

namespace App\DTOs;

use App\Models\Category;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class CategoryResponseDto implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $description
    ) {}

    public static function fromModel(Category $category): self
    {
        return new self(
            id: (int) $category->categoryId,
            name: $category->categoryName,
            description: $category->categoryDescription
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
