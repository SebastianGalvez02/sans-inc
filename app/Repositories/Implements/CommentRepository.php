<?php

namespace App\Repositories\Implements;

use App\Models\Comment;
use App\Repositories\Interfaces\ICommentRepository;

class CommentRepository implements ICommentRepository
{
    /**
     * Funcion que retorna todos los comentarios de la BD
     */
    public function getAll()
    {
        return Comment::all();
    }

    /**
     * Funcion que busca un comentario por su ID y lo retorna
     */
    public function findById(int $id)
    {
        return Comment::find($id);
    }

    /**
     * Funcion que retorna los comentarios asociados a una publicacion
     */
    public function getByPublicationId(int $publicationId)
    {
        return Comment::where('publicationId', $publicationId)
            ->get();
    }

    /**
     * Funcion que retorna los comentarios asociados a un usuario
     */
    public function getByUserId(int $userId)
    {
        return Comment::where('userId', $userId)
            ->get();
    }

    /**
     * Funcion que crea y guarda un nuevo comentario en la BD
     */
    public function create(array $data)
    {
        return Comment::create($data);
    }

    /**
     * Funcion que busca un comentario para actualizarlo con los datos dados y retorna
     */
    public function update(int $id, array $data)
    {
        $comment = Comment::findOrFail($id);
        $comment->update($data);
        return $comment;
    }

    /**
     * Funcion que elimina un comentario y retorna el resultado
     */
    public function delete(int $id)
    {
        $comment = Comment::findOrFail($id);
        return $comment->delete();
    }
}
