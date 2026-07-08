<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\IPublicationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\DTOs\PublicationRequestDto;
use App\Models\Role;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


class PublicationController extends Controller
{

    protected  IPublicationService $publicationService;

public function __construct(IPublicationService $publicationService)
{
    $this->publicationService = $publicationService;
}

public function index(Request $request): JsonResponse
{
    $validated = $request->validate([
        'productId'  => 'nullable|integer|exists:products,productId',
        'categoryId' => 'nullable|integer|exists:categories,categoryId',
    ]);

    $productId  = isset($validated['productId'])  ? (int) $validated['productId']  : null;
    $categoryId = isset($validated['categoryId']) ? (int) $validated['categoryId'] : null;

    if ($productId !== null && $categoryId !== null) {
        return response()->json(['error' => 'No puedes filtrar por productId y categoryId al mismo tiempo.'], 422);
    }

    $publications = $this->publicationService->listPublications($productId, $categoryId);
    return response()->json($publications);
}
public function show(int $id): JsonResponse
{
    try{
        $publication = $this -> publicationService -> getPublicationById($id);
        return response()->json($publication);
    }
    catch (ModelNotFoundException $e){
        return response()->json(['error' => $e->getMessage()], 404);
    }
}
public function store(Request $request): JsonResponse
{
    $this->ensureClient($request);

    $validated = $request->validate([
        'productId' => 'required|integer|exists:products,productId',
        'rating' => 'required|numeric|min:0|max:5',
        'review' => 'required|string|min:3|max:255',
    ]);

    try {
        $dto = new PublicationRequestDto(
            productId: (int) $validated['productId'],
            rating: (float) $validated['rating'],
            review: $validated['review']
        );

        $publication = $this->publicationService->createPublication(
            $dto,
            $request->user()->id
        );

        return response()->json($publication, 201);
    } catch (InvalidArgumentException $e) {
        return response()->json(['error' => $e->getMessage()], 422);
    }
}
 public function update(Request $request, int $id): JsonResponse
 {
     $this->ensureClient($request);

     $validated = $request->validate([
         'productId' => 'required|integer|exists:products,productId',
         'rating' => 'required|numeric|min:0|max:5',
         'review' => 'required|string|min:3|max:255',
     ]);

     try {
         $dto = new PublicationRequestDto(
             productId: (int) $validated['productId'],
             rating: (float) $validated['rating'],
             review: $validated['review']
         );

         $publication = $this->publicationService->updatePublication(
             $id,
             $dto,
             $request->user()->id
         );

         return response()->json($publication);
     } catch (ModelNotFoundException $e) {
         return response()->json(['error' => $e->getMessage()], 404);
     } catch (AccessDeniedHttpException $e) {
         return response()->json(['error' => $e->getMessage()], 403);
     } catch (InvalidArgumentException $e) {
         return response()->json(['error' => $e->getMessage()], 422);
     }
 }

 public function destroy(Request $request, int $id): JsonResponse
 {
     $this->ensureClient($request);
     try {
         $this->publicationService->deletePublication($id, $request->user()->id);
         return response()->json(null, 204);
     } catch (ModelNotFoundException $e) {
         return response()->json(['error' => $e->getMessage()], 404);
     } catch (AccessDeniedHttpException $e) {
         return response()->json(['error' => $e->getMessage()], 403);
     }
 }

 private function ensureClient(Request $request): void
 {
     $user = $request->user();
     if (!$user) {
         abort(401, 'Debes iniciar sesión.');
     }
     $clientRoleId = Role::where('role_name', 'client')->value('id');

     if ((int) $user->role_id !== (int) $clientRoleId) {
         abort(403, 'Solo los clientes pueden crear, editar o eliminar publicaciones.');
     }
 }
}
