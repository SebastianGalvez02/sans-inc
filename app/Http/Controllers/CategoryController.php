<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ICategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected ICategoryService $categoryService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->categoryService->listCategories());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $category = $this->categoryService->createCategory($validated);

        return response()->json($category, 201);
    }

    public function show(int $id): JsonResponse
    {
        try {
            return response()->json($this->categoryService->getCategory($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFound($e);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        try {
            $category = $this->categoryService->updateCategory($id, $validated);

            return response()->json($category);
        } catch (ModelNotFoundException $e) {
            return $this->notFound($e);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->categoryService->deleteCategory($id);

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return $this->notFound($e);
        }
    }

    private function notFound(ModelNotFoundException $e): JsonResponse
    {
        return response()->json([
            'error' => $e->getMessage(),
        ], 404);
    }
}
