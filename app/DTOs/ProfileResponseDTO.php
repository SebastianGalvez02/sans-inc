<?php
namespace App\DTOs;

use App\Models\User;

/**
 * ProfileResponseDTO
 * Shapes the user data returned after a profile update (RF-06).
 * Deliberately excludes sensitive fields such as the password hash.
 */
class ProfileResponseDTO
{
    public int $id;
    public string $name;
    public string $email;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
    }
}
