<?php

namespace App\Repositories\Eloquent;

use App\Models\Agenda;
use App\Repositories\Interfaces\IAgendaRepository;
use Illuminate\Database\Eloquent\Collection;

class AgendaRepository implements IAgendaRepository
{
    public function create(array $data): Agenda
    {
        return Agenda::create($data);
    }

    public function findByUser(int $userId): Collection
    {
        return Agenda::where('user_id', $userId)
            ->where('active', true)
            ->orderByDesc('scheduled_date')
            ->get();
    }

    public function findById(int $id): ?Agenda
    {
        return Agenda::find($id);
    }

    public function update(int $id, array $data): bool
    {
        return (bool) Agenda::where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        // RN-09: baja lógica, no borrado físico
        return (bool) Agenda::where('id', $id)->update(['active' => false]);
    }
}