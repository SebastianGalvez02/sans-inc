<?php

namespace App\DTOs;

/**
 * LoginRequestDTO
 * Carries the validated credentials from the login request into the controller logic.
 */
class LoginRequestDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}
}
