<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicationLike extends Model
{
    protected $table = 'publication_likes';

    public $timestamps = false;

    protected $fillable = [
        'userId',
        'publicationId',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function publication(): BelongsTo
    {
        return $this->belongsTo(Publication::class, 'publicationId', 'publicationId');
    }
}
