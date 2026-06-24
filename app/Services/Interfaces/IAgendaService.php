<?php

namespace App\Services\Interfaces;

use App\DTOs\AgendaCreateDto;
use App\Models\Agenda;
use Illuminate\Database\Eloquent\Collection;

interface IAgendaService
{
    public function createAgenda(AgendaCreateDto $dto): Agenda;

    public function getUserAgendas(int $userId): Collection;

    public function getAgenda(int $id): Agenda;

    public function cancelAgenda(int $id, int $requestingUserId): bool;
}
