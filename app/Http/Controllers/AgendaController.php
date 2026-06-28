<?php

namespace App\Http\Controllers;

use App\DTOs\AgendaCreateDto;
use App\Http\Requests\StoreAgendaRequest;
use App\Services\Interfaces\IAgendaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgendaController extends Controller
{
    public function __construct(
        private readonly IAgendaService $agendaService,
    ) {}

    public function index(Request $request): View
    {
        $agendas = $this->agendaService->getUserAgendas($request->user()->id);

        return view('agendas.index', compact('agendas'));
    }

    public function create(): View
    {
        return view('agendas.create');
    }

    public function store(StoreAgendaRequest $request): RedirectResponse
    {
        $dto = AgendaCreateDto::fromRequest($request->user()->id, $request->validated());
        $this->agendaService->createAgenda($dto);

        return redirect()->route('agenda.index')
            ->with('success', 'Agenda registrada correctamente.');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        $this->agendaService->cancelAgenda($id, $request->user()->id);

        return redirect()->route('agenda.index')
            ->with('success', 'Agenda cancelada correctamente.');
    }
}