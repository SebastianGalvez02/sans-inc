<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'productId';

    //Indica que la tabla no tiene columnas created_at ni updated_at
    public $timestamps = false;

    protected $fillable = [
        'categoryId',
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

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'categoryId');
    }
    /*
    public function publications()
    {
        return $this->hasMany(Publication::class, 'productId', 'productId');
    }
    */
}
