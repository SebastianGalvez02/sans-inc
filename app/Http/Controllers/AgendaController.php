<?php

namespace App\Http\Controllers;

use App\DTOs\AgendaCreateDto;
use App\Http\Requests\StoreAgendaRequest;
use App\Services\Interfaces\IAgendaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function __construct(
        private readonly IAgendaService $agendaService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $agendas = $this->agendaService->getUserAgendas($request->user()->id);

        return response()->json($agendas);
    }

    public function store(StoreAgendaRequest $request): JsonResponse
    {
        $dto = AgendaCreateDto::fromRequest($request->user()->id, $request->validated());
        $agenda = $this->agendaService->createAgenda($dto);

        return response()->json($agenda, 201);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->agendaService->cancelAgenda($id, $request->user()->id);

        return response()->json(['message' => 'Agenda cancelada correctamente.']);
    }
}