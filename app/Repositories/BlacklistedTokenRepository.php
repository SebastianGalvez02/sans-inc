<?php

namespace App\Repositories;

use App\Models\BlacklistedToken;
use Carbon\Carbon;

/**
 * BlacklistedTokenRepository
 * Handles all database interactions for the blacklisted_tokens table.
 * Follows the Repository pattern already used in this project.
 */
class BlacklistedTokenRepository
{
    /**
     * Persist a JWT to the blacklist.
     *
     * @param  int    $userId    ID of the authenticated user logging out
     * @param  string $token     Raw JWT string
     * @param  int    $expiresAt Unix timestamp taken from the token's 'exp' claim
     */
    public function blacklist(int $userId, string $token, int $expiresAt): BlacklistedToken
    {
        return BlacklistedToken::create([
            'user_id'    => $userId,
            'token'      => $token,
            'expires_at' => Carbon::createFromTimestamp($expiresAt),
        ]);
    }

    /**
     * Check whether a raw JWT string is currently blacklisted.
     */
    public function isBlacklisted(string $token): bool
    {
        return BlacklistedToken::isBlacklisted($token);
    }

    /**
     * Delete all expired entries from the blacklist.
     * Returns the number of rows deleted.
     */
    public function purgeExpired(): int
    {
        return BlacklistedToken::purgeExpired();
    }
}
