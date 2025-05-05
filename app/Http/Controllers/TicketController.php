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
        $tickets = Ticket::with('team')->get();
        return response()->json($tickets);
    }

    // Mostrar un ticket específico
    public function show($id)
    {
        $ticket = Ticket::with('team')->findOrFail($id);
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
}
