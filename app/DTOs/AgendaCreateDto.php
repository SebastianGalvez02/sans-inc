<?php

namespace App\DTOs;

/**
 * AgendaCreateDto
 * Data Transfer Object used to carry agenda creation data between layers.
 * Avoids passing raw request arrays directly into services and repositories.
 */
class AgendaCreateDto
{
    public function __construct(
        public readonly int    $userId,
        public readonly string $reason,
        public readonly string $scheduledDate,
        public readonly string $phone,
    ) {}

    /**
     * Build a DTO instance from a validated request array and the authenticated user ID.
     */
    public static function fromRequest(int $userId, array $validated): self
    {
        return new self(
            userId:        $userId,
            reason:        $validated['reason'],
            scheduledDate: $validated['scheduled_date'],
            phone:         $validated['phone'],
        );
    }

    /**
     * Convert the DTO to an array suitable for mass assignment in the repository.
     */
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