<?php

namespace App\Support;

use Illuminate\Validation\Rules\Password;

/**
 * PasswordRules
 * Single source of truth for the password complexity rules used across the
 * application. Mirrors the rules applied during registration / password reset
 * (see AuthController) so that any flow setting a password — such as the
 * profile password change (RF-06) — enforces exactly the same policy without
 * duplicating it.
 */
class PasswordRules
{
    /**
     * The strong-password rule set: minimum 8 characters, at least one letter,
     * one number and one symbol.
     *
     * @return array<int, mixed>
     */
    public static function strong(): array
    {
        return [Password::min(8)->letters()->numbers()->symbols()];
    }
}
