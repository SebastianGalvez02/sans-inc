<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $table = 'publications';
    protected $primaryKey = 'publicationId';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'publicationId',
        'rating',
        'publicationDate',
        'userId',
        'productId',
        'numberOfLikes',
        'active',
        'review'
    ];
    protected $casts = [
        'publicationDate' => 'datetime',
        'publicationId' => 'integer',
        'rating' => 'float',
        'userId' => 'integer',
        'productId' => 'integer',
        'numberOfLikes' => 'integer',
        'active' => 'boolean',
        'review' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'userId');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId', 'productId');
    }

    //  public function comments()
    //  {
    //      return $this->hasMany(Comment::class, 'publicationId', 'publicationId');
    //   }


}
