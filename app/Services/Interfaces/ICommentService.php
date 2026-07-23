<?php

namespace App\Services\Interfaces;

use App\DTOs\CommentRequestDto;
use App\DTOs\CommentResponseDto;
use Illuminate\Support\Collection;

interface ICommentService
{
    public function listComments(?int $publicationId = null): Collection;

    public function getCommentById(int $id): CommentResponseDto;

    public function createComment(CommentRequestDto $commentRequest, int $userId): CommentResponseDto;

    public function updateComment(int $id, string $content, int $userId): CommentResponseDto;

    public function deleteComment(int $id, int $userId): bool;
}
