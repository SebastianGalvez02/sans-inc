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
        return Publication::where('active', true)->get();
    }

    /**
     * Funcion que busca una publicación activa por su ID y la retorna
     */
    public function findActiveById(int $id)
    {
        return Publication::where('publicationId', $id)
            ->where('active', true)
            ->first();
    }

    /**
     * Funcion que retorna las publicaciones activas asociadas a un producto especifico
     */
    public function getByProductId(int $productId)
    {
        return Publication::where('productId', $productId)
            ->where('active', true)
            ->get();
    }

    /**
     * Funcion que retorna las publicaciones activas cuyo producto pertenece a una categoría
     */
    public function getByCategoryId(int $categoryId)
    {
        return Publication::whereHas('product', fn($q) => $q->where('categoryId', $categoryId))
            ->where('active', true)
            ->get();
    }

    /**
     * Funcion que retorna las publicaciones activas asociadas a un usuario
     */
    public function getByUserId(int $userId)
    {
        return Publication::where('userId', $userId)
            ->where('active', true)
            ->get();
    }

    
    /**
     * Funcion que crea y guarda una nueva publicación en la BD
     */
    public function create(array $data)
    {
        
        return Publication::create($data);
    }

    /**
     * Funcion que busca una publicacion para actualizarla con los datos dados y retorna
     */
    public function update(int $id, array $data)
    {
        $publication = Publication::findOrFail($id);
        $publication->update($data);
        return $publication;
    }
}