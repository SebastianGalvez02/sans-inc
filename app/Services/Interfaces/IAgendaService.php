<?php

namespace App\Services\Interfaces;

use App\DTOs\AgendaCreateDto;
use App\Models\Agenda;
use Illuminate\Database\Eloquent\Collection;

/**
 * IAgendaService
 * Defines the contract for agenda business logic operations.
 * Any implementation must fulfill these methods.
 */
interface IAgendaService
{
    /**
     * Create a new agenda from the given DTO.
     */
    public function createAgenda(AgendaCreateDto $dto): Agenda;

    /**
     * Retrieve all active agendas for the given user.
     */
    public function getUserAgendas(int $userId): Collection;

    /**
     * Find a single agenda by its ID.
     */
    public function getAgenda(int $id): ?Agenda;

    /**
     * Cancel an agenda, ensuring it belongs to the given user.
     */
    public function cancelAgenda(int $id, int $userId): bool;
}