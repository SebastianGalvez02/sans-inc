<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'productId';

    protected $fillable = [
        'name',
        'description',
        'price',
        'tag',
        'active'
    ];

    protected $casts = [
        'price' => 'float',
        'active' => 'boolean'
    ];


}