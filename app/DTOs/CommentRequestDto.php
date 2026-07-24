<?php

namespace App\DTOs;

class CommentRequestDto
{
    public function __construct(
        public readonly int $publicationId,
        public readonly string $content
    ) {
    }
}
