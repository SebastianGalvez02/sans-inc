<?php

namespace App\DTOs;

use App\Models\Product;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class ProductResponseDto implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly float $price,
        public readonly ?string $tag,
        public readonly int $categoryId,
        public readonly bool $active
    ) {
    }

    /**
     * Map Product model to ProductResponseDto.
     *
     * @param Product $product
     * @return self
     */
    public static function fromModel(Product $product): self
    {
        return new self(
            id: (int) $product->productId,
            name: $product->name,
            description: $product->description,
            price: (float) $product->price,
            tag: $product->tag,
            categoryId: (int) $product->categoryId,
            active: (bool) $product->active
        );
    }

    /**
     * Convert the DTO to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'tag' => $this->tag,
            'categoryId' => $this->categoryId,
            'active' => $this->active,
        ];
    }
    /**
     * Convert the object to its JSON serializable representation.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
