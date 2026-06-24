<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Services\Interfaces\IPublicationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class PublicationController extends controller
{

protected  IPublicationService $publicationService;


public function __construct(IPublicationService $publicationService)
{
    $this->publicationService = $publicationService;
}

public function index(Request $request)
{
    if ($request->has('productId'))
    {   $productId = (int) $request->query('productId');
        $rating = (float) $this-> publicationService  -> getPublicationById($productId) -> rating;
        $review = $this -> publicationService -> getPublicationById($productId) -> review;
    }
    return response()->json($review);
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

}
