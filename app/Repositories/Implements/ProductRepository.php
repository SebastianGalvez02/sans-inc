<?php
namespace App\Repositories\Implements;

use App\Models\Product;
use App\Repositories\Interfaces\IProductRepository;

class ProductRepository implements IProductRepository
{

    public function getAllActive()
    {
        return Product::where('active', true)->get();
    }

    public function findActiveById(int $id)
    {
        return Product::where('productId', $id)
            ->where('active', true)
            ->first();
    }

    public function getByCategoryId(int $categoryId)
    {
        return Product::where('categoryId', $categoryId)
            ->where('active', true)
            ->get();
    }
}
