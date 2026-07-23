<?php

namespace App\Services\Implements;

use App\DTOs\CommentRequestDto;
use App\DTOs\CommentResponseDto;
use App\Models\Comment;
use App\Repositories\Interfaces\ICommentRepository;
use App\Services\Interfaces\ICommentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CommentService implements ICommentService
{
    public function __construct(
        protected ICommentRepository $commentRepository
    ) {}

    public function listComments(?int $publicationId = null): Collection
    {
        $comments = $publicationId === null
            ? $this->commentRepository->getAll()
            : $this->commentRepository->getByPublicationId($publicationId);

        return $comments->map(
            fn (Comment $comment) => CommentResponseDto::fromModel($comment)
        );
    }

    public function getCommentById(int $id): CommentResponseDto
    {
        return CommentResponseDto::fromModel($this->findCommentOrFail($id));
    }

    public function createComment(CommentRequestDto $commentRequest, int $userId): CommentResponseDto
    {
        $comment = $this->commentRepository->create([
            'content' => $commentRequest->content,
            'userId' => $userId,
            'publicationId' => $commentRequest->publicationId,
        ]);

        return CommentResponseDto::fromModel($comment);
    }

    public function updateComment(int $id, string $content, int $userId): CommentResponseDto
    {
        $this->ensureOwner($this->findCommentOrFail($id), $userId, 'modify');

        return CommentResponseDto::fromModel(
            $this->commentRepository->update($id, ['content' => $content])
        );
    }

    public function deleteComment(int $id, int $userId): bool
    {
        $this->ensureOwner($this->findCommentOrFail($id), $userId, 'delete');

        return $this->commentRepository->delete($id);
    }

    private function findCommentOrFail(int $id): Comment
    {
        $comment = $this->commentRepository->findById($id);

        if (! $comment) {
            throw (new ModelNotFoundException)->setModel(Comment::class, [$id]);
        }

        return $comment;
    }

    private function ensureOwner(Comment $comment, int $userId, string $action): void
    {
        if ((int) $comment->userId !== $userId) {
            throw new AccessDeniedHttpException(
                "You do not have permission to {$action} this comment."
            );
        }
    }
}
