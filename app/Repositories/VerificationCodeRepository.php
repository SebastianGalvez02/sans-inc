<?php

namespace App\Repositories;

use App\Models\VerificationCode;
use App\Models\User;
use Carbon\Carbon;

/**
 * VerificationCodeRepository
 * Handles all database interactions for the verification_codes table.
 * Used for both failed login attempt tracking and password reset codes.
 */
class VerificationCodeRepository
{
    // Maximum failed attempts before temporary lockout
    const MAX_FAILED_ATTEMPTS = 5;

    // Lockout duration in minutes
    const LOCKOUT_MINUTES = 15;

    // Code expiry duration in minutes
    const CODE_EXPIRY_MINUTES = 15;

    // =========================================================================
    // Failed attempts — login lockout
    // =========================================================================

    /**
     * Retrieve the active verification record for a user, if any.
     */
    public function findByUser(int $userId): ?VerificationCode
    {
        return VerificationCode::where('user_id', $userId)
            ->latest()
            ->first();
    }

    /**
     * Check whether a user is currently locked out.
     * Returns true if date_to_resend is set and still in the future.
     */
    public function isLockedOut(int $userId): bool
    {
        $record = $this->findByUser($userId);

        if (!$record || !$record->date_to_resend) {
            return false;
        }

        return Carbon::now()->lt($record->date_to_resend);
    }

    /**
     * Returns the datetime when the lockout expires, or null if not locked.
     */
    public function lockoutExpiresAt(int $userId): ?Carbon
    {
        $record = $this->findByUser($userId);

        if (!$record || !$record->date_to_resend) {
            return null;
        }

        if (Carbon::now()->lt($record->date_to_resend)) {
            return Carbon::parse($record->date_to_resend);
        }

        return null;
    }

    /**
     * Increment the failed attempts counter for a user.
     * If the counter reaches MAX_FAILED_ATTEMPTS, sets date_to_resend to lock the account temporarily.
     * Creates the record if it does not exist yet.
     */
    public function incrementFailedAttempts(int $userId): VerificationCode
    {
        $record = VerificationCode::firstOrCreate(
            ['user_id' => $userId],
            [
                'code'            => '',
                'expires_at'      => Carbon::now()->addMinutes(self::CODE_EXPIRY_MINUTES),
                'failed_attempts' => 0,
                'date_to_resend'  => null,
            ]
        );

        $record->failed_attempts += 1;

        if ($record->failed_attempts >= self::MAX_FAILED_ATTEMPTS) {
            $record->date_to_resend = Carbon::now()->addMinutes(self::LOCKOUT_MINUTES);
        }

        $record->save();

        return $record;
    }

    /**
     * Reset the failed attempts counter and clear the lockout after a successful login.
     */
    public function resetFailedAttempts(int $userId): void
    {
        VerificationCode::where('user_id', $userId)->update([
            'failed_attempts' => 0,
            'date_to_resend'  => null,
        ]);
    }

    /**
     * Returns the number of remaining attempts before lockout.
     */
    public function remainingAttempts(int $userId): int
    {
        $record = $this->findByUser($userId);
        $used   = $record ? $record->failed_attempts : 0;

        return max(0, self::MAX_FAILED_ATTEMPTS - $used);
    }

    // =========================================================================
    // Password reset codes
    // =========================================================================

    /**
     * Generate and persist a new password reset code for a user.
     * Overwrites any existing record for that user.
     */
    public function createResetCode(int $userId): VerificationCode
    {
        // Delete any previous record to avoid duplicates
        VerificationCode::where('user_id', $userId)->delete();

        return VerificationCode::create([
            'user_id'         => $userId,
            'code'            => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
            'expires_at'      => Carbon::now()->addMinutes(self::CODE_EXPIRY_MINUTES),
            'failed_attempts' => 0,
            'date_to_resend'  => null,
        ]);
    }

    /**
     * Verify that a given code matches the stored record and has not expired.
     */
    public function verifyResetCode(int $userId, string $code): bool
    {
        return VerificationCode::where('user_id', $userId)
            ->where('code', $code)
            ->where('expires_at', '>', Carbon::now())
            ->exists();
    }

    /**
     * Delete the verification record after a successful password reset.
     */
    public function deleteByUser(int $userId): void
    {
        VerificationCode::where('user_id', $userId)->delete();
    }
}
