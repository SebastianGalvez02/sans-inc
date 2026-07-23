<?php

namespace App\Repositories\Interfaces;

use App\Models\Comment;
use Illuminate\Support\Collection;

interface ICommentRepository
{
    public function getAll(): Collection;

    public function findById(int $id): ?Comment;

    public function getByPublicationId(int $publicationId): Collection;

    public function getByUserId(int $userId): Collection;

    public function create(array $data): Comment;

    public function update(int $id, array $data): Comment;

    public function delete(int $id): bool;
}
