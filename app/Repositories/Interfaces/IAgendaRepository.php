<?php

namespace App\Repositories\Interfaces;

use App\DTOs\AgendaCreateDto;
use App\Models\Agenda;
use Illuminate\Database\Eloquent\Collection;

interface IAgendaRepository
{
    public function create(AgendaCreateDto $dto): Agenda;

    public function findByUser(int $userId): Collection;

    public function findById(int $id): ?Agenda;

    public function update(Agenda $agenda, array $data): Agenda;

    public function delete(Agenda $agenda): bool;
}
