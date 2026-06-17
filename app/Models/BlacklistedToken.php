<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * BlacklistedToken Model
 * Represents a JWT that has been invalidated upon user logout.
 * Any token stored here must be rejected by the auth middleware.
 */
class BlacklistedToken extends Model
{
    protected $table = 'blacklisted_tokens';

    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    /**
     * The user who owns the invalidated token.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /**
     * Check whether a raw JWT string is blacklisted.
     * Only considers tokens that have not yet naturally expired.
     */
    public static function isBlacklisted(string $token): bool
    {
        return self::where('token', $token)
            ->where('expires_at', '>', now())
            ->exists();
    }

    /**
     * Remove all tokens whose expiry has already passed.
     * Call this periodically (e.g. via a scheduled command) to keep the table lean.
     */
    public static function purgeExpired(): int
    {
        return self::where('expires_at', '<=', now())->delete();
    }
}
