<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\TicketRequest;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Mostrar todos los tickets
    public function index()
    {
        $tickets = Ticket::with('machines')->get();
        return response()->json($tickets);
    }

    // Mostrar un ticket específico
    public function show($id)
    {
        $ticket = Ticket::with('machines')->findOrFail($id);
        return response()->json($ticket);
    }

    // Crear un nuevo ticket
    public function store(TicketRequest $request)
    {
        $ticket = Ticket::create($request->validated());
        return response()->json($ticket, 201);
    }

    // Actualizar un ticket existente
    public function update(TicketRequest $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->validated());
        return response()->json($ticket);
    }

    // Eliminar un ticket
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return response()->noContent();
    }
        /**
     * buscar en cliente.
     */
    public function buscar(Request $request)
    {
        $query = $request->input('query');
        $startDate = $request->input('start_date'); // ej: "2024-01-01"
        $endDate = $request->input('end_date');     // ej: "2024-11-30"

        $resultados = Ticket::query();

        if ($query) {
            $resultados->where(function ($q) use ($query) {
                $q->where('incident_type', 'like', "%{$query}%")
                ->orWhere('client_name', 'like', "%{$query}%")
                ->orWhere('company', 'like', "%{$query}%")
                ->orWhere('area', 'like', "%{$query}%")
                ->orWhere('branch', 'like', "%{$query}%")
                ->orWhere('state', 'like', "%{$query}%")
                ->orWhere('registration_date', 'like', "%{$query}%");
            });
        }

        if ($startDate && $endDate) {
            $resultados->whereBetween('registration_date', [$startDate, $endDate]);
        }

        return response()->json($resultados->get());
    }
}
