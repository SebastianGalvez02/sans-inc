<?php

namespace App\DTOs;

use App\Models\Product;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * Clase para transportar datos de respuesta de productos.
 *
 * Expone una estructura estable para retornar productos desde la API
 * sin entregar directamente el modelo Eloquent.
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
class ProductResponseDto implements Arrayable, JsonSerializable
{
    /**
     * Inicializa los datos publicos de respuesta de un producto.
     *
     * @param int $id
     * @param string $name
     * @param string|null $description
     * @param float $price
     * @param string|null $tag
     * @param bool $active
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly float $price,
        public readonly ?string $tag,
        public readonly bool $active
    ) {
    }

    /**
     * Convierte un modelo Product en ProductResponseDto.
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
            active: (bool) $product->active
        );
    }

    /**
     * Convierte el DTO en un arreglo serializable.
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
            'active' => $this->active,
        ];
    }
    /**
     * Convierte el DTO en una estructura compatible con JSON.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
