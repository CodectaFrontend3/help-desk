<?php

namespace App\Http\Controllers;

use App\Models\ClienteG;
use Illuminate\Http\Request;

class ClienteGController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(ClienteG::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'direccion' => 'required|string|max:200',
            'correo' => 'required|email|max:50',
            'num_telefono' => 'required|string|max:9',
            'numero_plan' => 'required|integer',
        ]);
        $clienteG = ClienteG::create($request->all());
        return response()->json($clienteG, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $clienteG = ClienteG::findOrFail($id);
        return response()->json($clienteG);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'direccion' => 'required|string|max:200',
            'correo' => 'required|email|max:50',
            'num_telefono' => 'required|string|max:9',
            'numero_plan' => 'required|integer',
        ]);
        $clienteG = ClienteG::findOrFail($id);
        $clienteG->update($request->all());
        return response()->json($clienteG, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clienteG = ClienteG::findOrFail($id);
        $clienteG->delete();
        return response()->noContent();
    }
}
