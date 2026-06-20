<?php
namespace App\DTOs;
class PublicationRequestDto
{
    /* Los datos que el usuario entrega al crear o actualizar una publicación
     */

    public function __construct(
        public readonly int $productId,
        public readonly float $rating,
        public readonly string $review
    ) {
    }

}