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

		if (isset($validated['publicationId'])) {
			$comments = Comment::where('publicationId', (int) $validated['publicationId'])->get();
		} else {
			$comments = Comment::all();
		}

		return response()->json($comments);
	}

	public function show(int $id): JsonResponse
	{
		try {
			$comment = Comment::findOrFail($id);
			return response()->json($comment);
		} catch (ModelNotFoundException $e) {
			return response()->json(['error' => $e->getMessage()], 404);
		}
	}

	public function store(Request $request): JsonResponse
	{
		$user = $request->user();
		if (!$user) {
			abort(401, 'You must be logged in.');
		}

		$validated = $request->validate([
			'publicationId' => 'required|integer|exists:publications,publicationId',
			'content' => 'required|string|min:1|max:1000',
		]);

		$comment = Comment::create([
			'content' => $validated['content'],
			'publicationId' => (int) $validated['publicationId'],
			'userId' => $user->id,
		]);

		return response()->json($comment, 201);
	}

	public function update(Request $request, int $id): JsonResponse
	{
		$user = $request->user();
		if (!$user) {
			abort(401, 'Debes iniciar sesión.');
		}

		$validated = $request->validate([
			'content' => 'required|string|min:1|max:1000',
		]);

		try {
			$comment = Comment::findOrFail($id);

			if ((int) $comment->userId !== (int) $user->id) {
				throw new AccessDeniedHttpException('You do not have permission to modify this comment.');
			}

			$comment->content = $validated['content'];
			$comment->save();

			return response()->json($comment);
		} catch (ModelNotFoundException $e) {
			return response()->json(['error' => $e->getMessage()], 404);
		} catch (AccessDeniedHttpException $e) {
			return response()->json(['error' => $e->getMessage()], 403);
		}
	}

	public function destroy(Request $request, int $id): JsonResponse
	{
		$user = $request->user();
		if (!$user) {
			abort(401, 'You must be logged in.');
		}

		try {
			$comment = Comment::findOrFail($id);

			if ((int) $comment->userId !== (int) $user->id) {
				throw new AccessDeniedHttpException('You do not have permission to delete this comment.');
			}

			$comment->delete();
			return response()->json(null, 204);
		} catch (ModelNotFoundException $e) {
			return response()->json(['error' => $e->getMessage()], 404);
		} catch (AccessDeniedHttpException $e) {
			return response()->json(['error' => $e->getMessage()], 403);
		}
	}
}