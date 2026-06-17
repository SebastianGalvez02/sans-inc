<?php

namespace App\DTOs;

/**
 * ResetPasswordRequestDTO
 * Carries the validated data from the reset-password request.
 */
class ResetPasswordRequestDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $code,
        public readonly string $password,
    ) {}
}
