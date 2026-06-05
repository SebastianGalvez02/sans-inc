<?php

namespace App\DTOs;

use App\Models\User;

class RegisterResponseDTO
{
    public int $id;
    public string $name;
    public string $email;
    public string $registered_at;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->registered_at = $user->created_at->toDateTimeString();
    }
}
