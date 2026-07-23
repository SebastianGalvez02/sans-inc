<?php

namespace App\Http\Controllers;

use App\DTOs\CommentRequestDto;
use App\Services\Interfaces\ICommentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CommentController extends Controller
{
    public function __construct(
        protected ICommentService $commentService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'publicationId' => 'nullable|integer|exists:publications,publicationId',
        ]);

        $publicationId = isset($validated['publicationId'])
            ? (int) $validated['publicationId']
            : null;

        return response()->json(
            $this->commentService->listComments($publicationId)
        );
    }

    public function show(int $id): JsonResponse
    {
        try {
            return response()->json(
                $this->commentService->getCommentById($id)
            );
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Comment not found.'], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'publicationId' => 'required|integer|exists:publications,publicationId',
            'content' => 'required|string|min:3|max:255',
        ]);

        $comment = $this->commentService->createComment(
            new CommentRequestDto(
                publicationId: (int) $validated['publicationId'],
                content: $validated['content']
            ),
            (int) $request->user()->id
        );

        return response()->json($comment, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|min:3|max:255',
        ]);

        try {
            $comment = $this->commentService->updateComment(
                $id,
                $validated['content'],
                (int) $request->user()->id
            );

            return response()->json($comment);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Comment not found.'], 404);
        } catch (AccessDeniedHttpException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        try {
            $this->commentService->deleteComment(
                $id,
                (int) $request->user()->id
            );

            return response()->json([
                'message' => 'Comment deleted successfully.',
            ]);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Comment not found.'], 404);
        } catch (AccessDeniedHttpException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
