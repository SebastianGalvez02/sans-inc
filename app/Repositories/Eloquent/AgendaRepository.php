<?php

namespace App\Repositories\Eloquent;

use App\DTOs\AgendaCreateDto;
use App\Models\Agenda;
use App\Repositories\Interfaces\IAgendaRepository;
use Illuminate\Database\Eloquent\Collection;

class AgendaRepository implements IAgendaRepository
{
    public function create(AgendaCreateDto $dto): Agenda
    {
        return Agenda::create($dto->toArray());
    }

    public function findByUser(int $userId): Collection
    {
        return Agenda::where('user_id', $userId)
            ->where('active', true)
            ->orderBy('scheduled_date')
            ->get();
    }

    public function findById(int $id): ?Agenda
    {
        return Agenda::find($id);
    }

    public function update(Agenda $agenda, array $data): Agenda
    {
        $agenda->update($data);

        return $agenda;
    }

    public function delete(Agenda $agenda): bool
    {
        return $agenda->update(['active' => false]);
    }
}
