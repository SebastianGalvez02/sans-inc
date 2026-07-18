<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * User Model
 * Represents the 'users' table in the database.
 * Implements JWTSubject so tymon/jwt-auth can generate tokens for this model.
 *
 * NOTE: HasApiTokens (Sanctum) has been removed — the project now uses JWT exclusively.
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    // Defines which fields can be mass-assigned securely
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'recovery_email',
    ];

    // Hides sensitive data from API responses
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast definitions.
     * The 'hashed' cast automatically bcrypts the password on assignment.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'email_verified_at' => 'datetime',
        ];
    }

    // =========================================================================
    // JWTSubject interface — required by tymon/jwt-auth
    // =========================================================================

    /**
     * Returns the value used as the JWT subject claim ('sub').
     * This is the primary key of the user record.
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Returns any extra claims to merge into the JWT payload.
     * role_id is included so the frontend can display role-aware UI without
     * making a separate API call.
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'role_id' => $this->role_id,
        ];
    }

    /**
     * Relationship: a user belongs to one role (client, admin, etc).
     */
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function publications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Publication::class, 'userId', 'id');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'userId', 'id');
    }
}
