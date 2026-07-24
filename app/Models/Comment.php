<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'content',
        'userId',
        'publicationId',
    ];

    protected $casts = [
        'id' => 'integer',
        'userId' => 'integer',
        'publicationId' => 'integer',
        'content' => 'string',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function publication()
    {
        return $this->belongsTo(Publication::class, 'publicationId', 'publicationId');
    }
}
