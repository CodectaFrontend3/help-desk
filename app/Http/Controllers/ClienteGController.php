<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteGRequest;
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
    public function store(ClienteGRequest $request)
    {
        $clienteG = ClienteG::create($request->validated());
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
    public function update(ClienteGRequest $request, string $id)
    {
        $clienteG = ClienteG::findOrFail($id);
        $clienteG->update($request->validated());
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
