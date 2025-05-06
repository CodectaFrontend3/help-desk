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
        $registroHardware = ClienteG::create($request->validated());
        return response()->json($registroHardware, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $registroHardware = ClienteG::findOrFail($id);
        return response()->json($registroHardware);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClienteGRequest $request, string $id)
    {
        $registroHardware = ClienteG::findOrFail($id);
        $registroHardware->update($request->validated());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registroHardware = ClienteG::findOrFail($id);
        $registroHardware->delete();
        return response()->noContent();
    }

}
