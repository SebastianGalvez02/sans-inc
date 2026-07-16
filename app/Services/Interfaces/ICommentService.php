<?php

use App\DTOs\CommentRequestDto;
use App\DTOs\PublicationRequestDto;
use App\Repositories\Interfaces\ICommentRepository;

interface ICommentService{
    public function create(CommentRequestDto $commentRequest);
    public function getComments(CommentRequestDto $commentRequestDto);
    public function deleteComment(CommentRequestDto $commentRequestDto, ICommentRepository $commentRepository);
    public function getComment(CommentRequestDto $commentRequestDto, ICommentRepository $commentRepository);
}
