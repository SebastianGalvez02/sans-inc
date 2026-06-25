<?php

namespace App\DTOs;

class AgendaCreateDto
{
    public function __construct(
        public readonly int $userId,
        public readonly string $reason,
        public readonly string $scheduledDate,
        public readonly string $phone,
    ) {
    }

    public static function fromRequest(array $data, int $userId): self
    {
        return new self(
            userId: $userId,
            reason: $data['reason'],
            scheduledDate: $data['scheduled_date'],
            phone: $data['phone'],
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'reason' => $this->reason,
            'scheduled_date' => $this->scheduledDate,
            'phone' => $this->phone,
        ];
    }
}
