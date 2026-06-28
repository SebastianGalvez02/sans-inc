<?php

namespace App\Services;

use App\DTOs\AgendaCreateDto;
use App\Models\Agenda;
use App\Repositories\Interfaces\IAgendaRepository;
use App\Services\Interfaces\IAgendaService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;

class AgendaService implements IAgendaService
{
    public function __construct(
        private readonly IAgendaRepository $agendaRepository,
    ) {}

    public function createAgenda(AgendaCreateDto $dto): Agenda
    {
        return $this->agendaRepository->create($dto->toArray());
    }

    public function getUserAgendas(int $userId): Collection
    {
        return $this->agendaRepository->findByUser($userId);
    }

    public function getAgenda(int $id): ?Agenda
    {
        return $this->agendaRepository->findById($id);
    }

    public function cancelAgenda(int $id, int $userId): bool
    {
        $agenda = $this->agendaRepository->findById($id);

        if (!$agenda || $agenda->user_id !== $userId) {
            throw new AuthorizationException('No tienes permiso para cancelar esta agenda.');
        }

        return $this->agendaRepository->delete($id);
    }
}