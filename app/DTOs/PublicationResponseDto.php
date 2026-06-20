<?php

namespace App\DTOs;

use App\Models\Publication;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class PublicationResponseDto implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly int $publicationId,
        public readonly int $productId,
        public readonly float $rating,
        public readonly string $review,
        public readonly int $numberOfLikes,
        public readonly string $publicationDate,
        // Acá por si quisiéramos en un futuro mostrar el nombre del usuario
        public readonly int $userId,
        // public readonly string $userName, // Futura relacion con el nombre del usuario
    ) {
    }

    public static function fromModel(Publication $publication): self
    {
        return new self(
            publicationId: (int) $publication->publicationId,
            productId: (int) $publication->productId,
            rating: (float) $publication->rating,
            review: (string) $publication->review,
            numberOfLikes: (int) $publication->numberOfLikes,
            // Formateamos la fecha a un string seguro (ISO 8601)
            publicationDate: $publication->publicationDate->toIso8601String(),
            userId: (int) $publication->userId,
        );
    }

    public function toArray(): array
    {
        return [
            'publicationId' => $this->publicationId,
            'productId' => $this->productId,
            'rating' => $this->rating,
            'review' => $this->review,
            'numberOfLikes' => $this->numberOfLikes,
            'publicationDate' => $this->publicationDate,
            'userId' => $this->userId,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
