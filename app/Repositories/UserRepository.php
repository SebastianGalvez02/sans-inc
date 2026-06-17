<?php

namespace App\Repositories;

use App\Models\User;

/**
 * UserRepository
 * Handles all database interactions for the users table.
 */
class UserRepository
{
    /**
     * Check whether an email address is already registered.
     */
    public function existsByEmail(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    /**
     * Find a user by their email address.
     * Returns null if no matching user is found.
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Persist a User entity to the database.
     */
    public function save(User $user): User
    {
        $user->save();
        return $user;
    }
}
