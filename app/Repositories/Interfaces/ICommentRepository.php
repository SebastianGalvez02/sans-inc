<?php

namespace App\Repositories\Interfaces;

interface ICommentRepository
{
    public function getAll();

    public function findById(int $id);

    public function getByPublicationId(int $publicationId);

    public function getByUserId(int $userId);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
