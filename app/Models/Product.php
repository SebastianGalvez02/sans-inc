<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Clase para representar productos del sistema.
 *
 * Define la tabla, la llave primaria, los atributos asignables y
 * las relaciones asociadas al modelo Product.
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'productId';

    // Indica que la tabla no tiene columnas created_at ni updated_at.
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

    /**
     * Relaciona el producto con su categoria principal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'categoryId');
    }

    public function publications()
    {
        return $this->hasMany(Publication::class, 'productId', 'productId');
    }
}
