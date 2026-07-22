<?php

namespace App\Http\Controllers;

use App\DTOs\AgendaCreateDto;
use App\Http\Requests\StoreAgendaRequest;
use App\Services\Interfaces\IAgendaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AgendaController
 * Handles HTTP requests related to agenda management.
 * Delegates all business logic to the AgendaService.
 */
class AgendaController extends Controller
{
    public function __construct(
        private readonly IAgendaService $agendaService,
    ) {}

    /**
     * Return all active agendas for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $agendas = $this->agendaService->getUserAgendas($request->user()->id);

        return response()->json($agendas);
    }

    /**
     * Create a new agenda for the authenticated user.
     */
    public function store(StoreAgendaRequest $request): JsonResponse
    {
        $dto = AgendaCreateDto::fromRequest($request->user()->id, $request->validated());
        $agenda = $this->agendaService->createAgenda($dto);

        return response()->json($agenda, 201);
    }

    /**
     * Cancel an agenda belonging to the authenticated user.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->agendaService->cancelAgenda($id, $request->user()->id);

        return response()->json(['message' => 'Agenda cancelada correctamente.']);
    }
}