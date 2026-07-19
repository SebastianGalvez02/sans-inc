<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CommentController extends Controller
{
	public function index(Request $request): JsonResponse
	{
		$validated = $request->validate([
            'publicationId' => 'nullable|integer|exists:publications,publicationId',
        ]);

		$query = Comment::where('activo', true);

		if (isset($validated['publicationId'])) {
            $comments = $query->where('publicationId', (int) $validated['publicationId'])->get();
        } else {
            $comments = $query->get();
        }

		return response()->json($comments);
	}

	public function show(int $id): JsonResponse
	{
		try {
            $comment = Comment::where('activo', true)->findOrFail($id);
            return response()->json($comment);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Comment not found.'], 404);
        }
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

		$comment = Comment::create([
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
        $comment = Comment::where('activo', true)->findOrFail($id);
        if ((int) $comment->userId !== (int) $user->id) {
            throw new AccessDeniedHttpException('You do not have permission to modify this comment.');
        }

        $comment->comentario = $validated['content'];
        $comment->save();

        return response()->json($comment);

    	} catch (ModelNotFoundException $e) {
         	return response()->json(['error' => 'Comment not found.'], 404);
    	} catch (AccessDeniedHttpException $e) {
        	return response()->json(['error' => $e->getMessage()], 403);
    	}
	}

	public function destroy(Request $request, int $id): JsonResponse
	{
		$user = auth()->user();
    	if (!$user) {
        	return response()->json(['error' => 'You must be logged in.'], 401);
    	}

		try {
        $comment = Comment::where('activo', true)->findOrFail($id);

        if ((int) $comment->userId !== (int) $user->id) {
            throw new AccessDeniedHttpException('You do not have permission to delete this comment.');
        }

        $comment->activo = false;
        $comment->save();

        return response()->json(['message' => 'Comment deleted successfully.'], 200);

    	} catch (ModelNotFoundException $e) {
        	return response()->json(['error' => 'Comment not found.'], 404);
    	} catch (AccessDeniedHttpException $e) {
        	return response()->json(['error' => $e->getMessage()], 403);
    	}
	}
}