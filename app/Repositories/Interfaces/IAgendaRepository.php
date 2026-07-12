<?php

namespace App\Repositories\Interfaces;

use App\Models\Agenda;
use Illuminate\Database\Eloquent\Collection;

/**
 * IAgendaRepository
 * Defines the contract for agenda data access operations.
 * Any implementation must fulfill these methods.
 */
interface IAgendaRepository
{
    /**
     * Create a new agenda record in the database.
     */
    public function create(array $data): Agenda;

    /**
     * Retrieve all active agendas belonging to a specific user.
     */
    public function findByUser(int $userId): Collection;

    /**
     * Find a single agenda by its ID.
     */
    public function findById(int $id): ?Agenda;

    /**
     * Update an existing agenda record.
     */
    public function update(int $id, array $data): bool;

    /**
     * Perform a logical delete on an agenda (sets active to false).
     */
    public function delete(int $id): bool;
}