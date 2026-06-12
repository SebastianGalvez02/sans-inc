<?php
namespace App\Repositories;
use App\Models\User;
class UserRepository
{
    /**
     * Verifica si el correo ya existe en la base de datos
     */
    public function existsByEmail(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    /**
     * Guarda la entidad User en la base de datos
     */
    public function save(User $user): User
    {
        $user->save();
        return $user;
    }
}
