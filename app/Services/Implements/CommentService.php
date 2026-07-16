<?php

use App\Services\Interfaces\ICategoryService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use app\Models\Comment;
use app\Repositories\Interfaces\ICommentRepository;

class CommentService implements ICommentService{

    public function create(\App\DTOs\CommentRequestDto $commentRequest)
    {
        return Comment::create([
            'content'       => $commentRequest->content,
            'userId'        => $commentRequest->userId,
            'publicationId' => $commentRequest->publicationId,
        ]);

    }

    public function getComments(\App\DTOs\CommentRequestDto $commentRequestDto)
    {
        return Comment::where('publicationId', $commentRequestDto->publicationId)
            ->paginate(10);
    }

    public function deleteComment(\App\DTOs\CommentRequestDto $commentRequestDto, ICommentRepository $commentRepository)
    {
        /// falta arreglar el $comment porque aun no agarra el comentario por id de usuario
        $comment = $this->$commentRepository->getByUserId();

        if (Gate::denies('delete', $comment)) {
            throw new AuthorizationException(
                'No tienes permiso para eliminar este comentario.'
            );
        }

        return $comment->delete();

    }

    public function getComment(\App\DTOs\CommentRequestDto $commentRequestDto, ICommentRepository $commentRepository)
    {
        // TODO: Implement getComment() method.
    }
}
