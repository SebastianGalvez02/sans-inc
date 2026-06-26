<?php

namespace App\Services;

use App\DTOs\AgendaCreateDto;
use App\Models\Agenda;
use App\Repositories\Interfaces\IAgendaRepository;
use App\Services\Interfaces\IAgendaService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AgendaService implements IAgendaService
{
    public function __construct(
        private readonly IAgendaRepository $agendaRepository,
    ) {
    }

    public function createAgenda(AgendaCreateDto $dto): Agenda
    {
        return $this->agendaRepository->create($dto);
    }

    public function getUserAgendas(int $userId): Collection
    {
        return $this->agendaRepository->findByUser($userId);
    }

    public function getAgenda(int $id): Agenda
    {
        $agenda = $this->agendaRepository->findById($id);

        if (! $agenda) {
            throw new NotFoundHttpException('Agenda no encontrada.');
        }

        return $agenda;
    }

    public function cancelAgenda(int $id, int $requestingUserId): bool
    {
        $agenda = $this->getAgenda($id);

        if ($agenda->user_id !== $requestingUserId) {
            throw ValidationException::withMessages([
                'agenda' => 'No tienes permiso para cancelar esta agenda.',
            ]);
        }

        return $this->agendaRepository->delete($agenda);
    }
}
