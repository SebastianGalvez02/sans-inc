<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'reason',
        'scheduled_date',
        'phone',
        'active',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
        'active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
