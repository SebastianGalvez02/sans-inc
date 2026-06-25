<?php

namespace App\DTOs;

/**
 * ForgotPasswordRequestDTO
 * Carries the validated email from the forgot-password request.
 */
class ForgotPasswordRequestDTO
{
    public function __construct(
        public readonly string $email,
    ) {}
}
