<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\IProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected IProductService $productService;

    /**
     * ProductController constructor.
     *
     * @param IProductService $productService
     */
    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * List products (optionally filtered by categoryId).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->has('categoryId')) {
            $categoryId = (int) $request->query('categoryId');
            $products = $this->productService->listProductsByCategory($categoryId);
        } else {
            $products = $this->productService->listAvailableProducts();
        }

        return response()->json($products);
    }

    /**
     * Get a single product for review.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $product = $this->productService->getProductForReview($id);
            return response()->json($product);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
