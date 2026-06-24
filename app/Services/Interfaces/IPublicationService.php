<?php

namespace App\Services\Interfaces;

use App\DTOs\PublicationRequestDto;
use App\DTOs\PublicationResponseDto;
use Illuminate\Support\Collection;

interface IPublicationService
{
    public function listPublications(?int $productId = null): Collection;

    public function getPublicationById(int $id): PublicationResponseDto;

    public function getPublicationsByOwner(int $userId): Collection; 

    public function createPublication(PublicationRequestDto $dto, int $userId): PublicationResponseDto;

    public function updatePublication(int $id, PublicationRequestDto $dto, int $userId): PublicationResponseDto;

    public function deletePublication(int $id, int $userId): bool;
}