<?php

namespace App\DTOs;

use App\Models\User;

/**
 * LoginResponseDTO
 * Shapes the data returned to the client after a successful login.
 * Keeps sensitive fields (password, remember_token, etc.) out of the response.
 */
class LoginResponseDTO
{
    public readonly int    $id;
    public readonly string $name;
    public readonly string $email;
    public readonly int    $role_id;
    public readonly string $token;
    public readonly string $token_type;

    public function __construct(User $user, string $token)
    {
        $this->id         = $user->id;
        $this->name       = $user->name;
        $this->email      = $user->email;
        $this->role_id    = $user->role_id;
        $this->token      = $token;
        $this->token_type = 'bearer';
    }
}
