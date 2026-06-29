<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * User Model
 * Represents the 'users' table in the database.
 * Handles authentication, API tokens, and soft deletes.
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    // Defines which fields can be mass-assigned securely
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'recovery_email',
    ];

    // Hides sensitive data from API responses (like Postman)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     * Automatically hashes the password when saving to the database.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
{
    return $this->belongsTo(Role::class);
}
}
