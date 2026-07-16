<?php

namespace App\Services;

use App\DTOs\AgendaCreateDto;
use App\Models\Agenda;
use App\Repositories\Interfaces\IAgendaRepository;
use App\Services\Interfaces\IAgendaService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

/**
 * AgendaService
 * Handles all business logic related to agenda management.
 * Validates ownership before allowing cancellations.
 */
class AgendaService implements IAgendaService
{
    public function __construct(
        private readonly IAgendaRepository $agendaRepository,
    ) {}

    /**
     * Create a new agenda using the provided DTO.
     */
    public function createAgenda(AgendaCreateDto $dto): Agenda
    {
        return $this->agendaRepository->create($dto->toArray());
    }

    /**
     * Retrieve all active agendas for a given user.
     */
    public function getUserAgendas(int $userId): Collection
    {
        return $this->agendaRepository->findByUser($userId);
    }

    /**
     * Find a single agenda by its ID.
     */
    public function getAgenda(int $id): ?Agenda
    {
        return $this->agendaRepository->findById($id);
    }

    /**
     * Cancel an agenda.
     * - Agenda inexistente -> ModelNotFoundException (404).
     * - Agenda de otro usuario -> ValidationException (422).
     */
    public function cancelAgenda(int $id, int $userId): bool
    {
        $agenda = $this->agendaRepository->findById($id);

        if (!$agenda) {
            throw new ModelNotFoundException('Agenda no encontrada.');
        }

        if ($agenda->user_id !== $userId) {
            throw ValidationException::withMessages([
                'agenda' => ['No tienes permiso para cancelar esta agenda.'],
            ]);
        }

        return $this->agendaRepository->delete($id);
    }
}
