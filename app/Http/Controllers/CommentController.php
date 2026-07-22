<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ICommentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CommentController extends Controller
{
	protected $commentRepository;

	public function __construct(ICommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
	
	public function index(Request $request): JsonResponse
	{
		$validated = $request->validate([
            'publicationId' => 'nullable|integer|exists:publications,publicationId',
        ]);

		if (isset($validated['publicationId'])) {
            $comments = $this->commentRepository->getByPublicationId((int) $validated['publicationId']);
        } else {
            $comments = $this->commentRepository->getAll();
        }

		return response()->json($comments);
	}

	public function show(int $id): JsonResponse
	{
		$comment = $this->commentRepository->findById($id);
		if (!$comment) {
            return response()->json(['error' => 'Comment not found.'], 404);
        }

		return response()->json($comment);
	}

	public function store(Request $request): JsonResponse
	{
		$user = auth()->user(); 
    	if (!$user) {
        	return response()->json(['error' => 'You must be logged in.'], 401);
    	}

		$validated = $request->validate([
        	'publicationId' => 'required|integer|exists:publications,publicationId',
        	'content' => 'required|string|min:3|max:255',
    	]);

		$comment = $this->commentRepository->create([
            'comentario' => $validated['content'],
            'publicationId' => (int) $validated['publicationId'],
            'userId' => $user->id,
            'activo' => true,
        ]);
	
		return response()->json($comment, 201);
	}

	
	public function update(Request $request, int $id): JsonResponse
	{
		$user = auth()->user();
        if (!$user) {
    		return response()->json(['error' => 'You must be logged in.'], 401);
    	}

		$validated = $request->validate([
       		'content' => 'required|string|min:3|max:255',
    	]);

		try {
            $comment = $this->commentRepository->findById($id);

            if (!$comment) {
                return response()->json(['error' => 'Comment not found.'], 404);
            }

            if ((int) $comment->userId !== (int) $user->id) {
                throw new AccessDeniedHttpException('You do not have permission to modify this comment.');
            }

            $updatedComment = $this->commentRepository->update($id, [
                'comentario' => $validated['content']
            ]);

            return response()->json($updatedComment);

        } catch (AccessDeniedHttpException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
	}

	public function destroy(Request $request, int $id): JsonResponse
	{$user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'You must be logged in.'], 401);
        }

        try {
            $comment = $this->commentRepository->findById($id);

            if (!$comment) {
                return response()->json(['error' => 'Comment not found.'], 404);
            }

            if ((int) $comment->userId !== (int) $user->id) {
                throw new AccessDeniedHttpException('You do not have permission to delete this comment.');
            }

            // Llamada a la baja lógica del repositorio
            $this->commentRepository->delete($id);

            return response()->json(['message' => 'Comment deleted successfully.'], 200);

        } catch (AccessDeniedHttpException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
	}
}