<?php

namespace App\DTOs;

use App\Models\Comment;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class CommentResponseDto implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly string $content,
        public readonly int $userId,
        public readonly int $publicationId,
        public readonly string $createdAt
    ) {
    }

    public static function fromModel(Comment $comment): self
    {
        return new self(
            id: (int) $comment->id,
            content: (string) $comment->content,
            userId: (int) $comment->userId,
            publicationId: (int) $comment->publicationId,
            createdAt: $comment->created_at ? $comment->created_at->toIso8601String() : ''
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'userId' => $this->userId,
            'publicationId' => $this->publicationId,
            'createdAt' => $this->createdAt,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
