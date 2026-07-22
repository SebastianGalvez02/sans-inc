<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Agenda Model
 * Represents the 'agendas' table in the database.
 * Handles contact requests made by client users.
 */
class Agenda extends Model
{
    use SoftDeletes;

    // Defines which fields can be mass-assigned securely
    protected $fillable = [
        'user_id',
        'reason',
        'scheduled_date',
        'phone',
        'active',
    ];

    // Automatically casts fields to their proper types
    protected $casts = [
        'scheduled_date' => 'datetime',
        'active'         => 'boolean',
    ];

    /**
     * Get the user that owns the agenda.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}