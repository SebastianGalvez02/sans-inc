<?php
namespace App\Repositories\Implements;

use App\Models\Product;
use App\Repositories\Interfaces\IProductRepository;

/**
 * Clase para consultar productos mediante Eloquent.
 *
 * Implementa las consultas necesarias para obtener productos activos,
 * productos por identificador y productos por categoria.
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
class ProductRepository implements IProductRepository
{

    /**
     * Consulta todos los productos activos.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Product>
     */
    public function getAllActive()
    {
        return Product::where('active', true)->get();
    }

    /**
     * Consulta un producto activo por su identificador.
     *
     * @param int $id
     * @return Product|null
     */
    public function findActiveById(int $id)
    {
        return Product::where('productId', $id)
            ->where('active', true)
            ->first();
    }

    /**
     * Consulta productos activos asociados a una categoria.
     *
     * @param int $categoryId
     * @return \Illuminate\Database\Eloquent\Collection<int, Product>
     */
    public function getByCategoryId(int $categoryId)
    {
        return Product::where('categoryId', $categoryId)
            ->where('active', true)
            ->get();
    }
}
