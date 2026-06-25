<?php

namespace App\Repositories\Implements;

use App\Models\Publication;
use App\Repositories\Interfaces\IPublicationRepository;

class PublicationRepository implements IPublicationRepository
{
    /**
     * Funcion que retorna todas las publicaciones activas de la BD
     */
    public function getAllActive()
    {
        return Publication::with('product.category')
            ->where('active', true)
            ->get();
    }

    /**
     * Funcion que busca una publicación activa por su ID y la retorna
     */
    public function findActiveById(int $id)
    {
        return Publication::where('publicationId', $id)
            ->with('product.category')
            ->where('active', true)
            ->first();
    }

    /**
     * Funcion que retorna las publicaciones activas asociadas a un producto especifico
     */
    public function getByProductId(int $productId)
    {
        return Publication::with('product.category')
            ->where('productId', $productId)
            ->where('active', true)
            ->get();
    }

    /**
     * Funcion que retorna las publicaciones activas asociadas a una categoria de producto
     */
    public function getByCategoryId(int $categoryId)
    {
        return Publication::with('product.category')
            ->where('active', true)
            ->whereHas('product', function ($query) use ($categoryId) {
                $query->where('categoryId', $categoryId);
            })
            ->get();
    }

    /**
     * Funcion que retorna las publicaciones activas asociadas a un usuario 
     */
    public function getByUserId(int $userId)
    {
        return Publication::with('product.category')
            ->where('userId', $userId)
            ->where('active', true)
            ->get();
    }

    
    /**
     * Funcion que crea y guarda una nueva publicación en la BD
     */
    public function create(array $data)
    {
        
        return Publication::create($data)->load('product.category');
    }

    /**
     * Funcion que busca una publicacion para actualizarla con los datos dados y retorna
     */
    public function update(int $id, array $data)
    {
        $publication = Publication::findOrFail($id);
        $publication->update($data);
        return $publication->load('product.category');
    }
}
