<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\IProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Clase para procesar peticiones HTTP del modulo productos.
 *
 * Gestiona el listado de productos activos, el filtro por categoria
 * y la consulta individual de productos disponibles para resenas.
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
class ProductController extends Controller
{
    protected IProductService $productService;

    /**
     * Inicializa el controlador con el servicio de productos.
     *
     * @param IProductService $productService
     */
    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Realiza el listado de productos activos.
     *
     * Si existe el parametro categoryId, devuelve solo productos
     * activos asociados a esa categoria.
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
     * Obtiene un producto activo por su identificador.
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
