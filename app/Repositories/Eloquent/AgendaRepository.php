<?php

namespace App\Repositories\Eloquent;

use App\Models\Agenda;
use App\Repositories\Interfaces\IAgendaRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * AgendaRepository
 * Eloquent implementation of IAgendaRepository.
 * Handles all database operations for the Agenda model.
 */
class AgendaRepository implements IAgendaRepository
{
    /**
     * Create a new agenda record in the database.
     */
    public function create(array $data): Agenda
    {
        return Agenda::create($data);
    }

    /**
     * Retrieve all active agendas for a given user, ordered by scheduled date descending.
     */
    public function findByUser(int $userId): Collection
    {
        return Agenda::where('user_id', $userId)
            ->where('active', true)
            ->orderByDesc('scheduled_date')
            ->get();
    }

    /**
     * Find a single agenda by its primary key.
     */
    public function findById(int $id): ?Agenda
    {
        return Agenda::find($id);
    }

    /**
     * Update fields of an existing agenda record.
     */
    public function update(int $id, array $data): bool
    {
        return (bool) Agenda::where('id', $id)->update($data);
    }

    /**
     * Perform a logical delete by setting active to false (RN-09).
     * Records are never physically removed from the database.
     */
    public function delete(int $id): bool
    {
        return (bool) Agenda::where('id', $id)->update(['active' => false]);
    }
}