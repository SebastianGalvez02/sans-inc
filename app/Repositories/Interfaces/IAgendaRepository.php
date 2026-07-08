<?php

namespace App\Repositories\Interfaces;

use App\Models\Agenda;
use Illuminate\Database\Eloquent\Collection;

interface IAgendaRepository
{
    public function create(array $data): Agenda;

    public function findByUser(int $userId): Collection;

    public function findById(int $id): ?Agenda;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}