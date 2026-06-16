<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'categoryId';

    protected $fillable =[
      'categoryName',
      'categoryDescription'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'categoryId', 'categoryId');
    }
}
