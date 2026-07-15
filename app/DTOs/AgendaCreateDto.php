<?php

namespace App\DTOs;

class AgendaCreateDto
{
    public function __construct(
        public readonly int    $userId,
        public readonly string $reason,
        public readonly string $scheduledDate,
        public readonly string $phone,
    ) {}

    public static function fromRequest(int $userId, array $validated): self
    {
        return new self(
            userId:        $userId,
            reason:        $validated['reason'],
            scheduledDate: $validated['scheduled_date'],
            phone:         $validated['phone'],
        );
    }

    public function toArray(): array
    {
        return [
            'user_id'        => $this->userId,
            'reason'         => $this->reason,
            'scheduled_date' => $this->scheduledDate,
            'phone'          => $this->phone,
        ];
    }
}