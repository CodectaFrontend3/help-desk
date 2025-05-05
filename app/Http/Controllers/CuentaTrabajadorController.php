<?php

namespace App\Http\Controllers;

use App\Http\Requests\CuentaTrabajadorRequest;
use App\Models\CuentaTrabajador;
use Illuminate\Http\Request;

class CuentaTrabajadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(CuentaTrabajador::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CuentaTrabajadorRequest $request)
    {
        $registroHardware = CuentaTrabajador::create($request->validated());
        return response()->json($registroHardware, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $registroHardware = CuentaTrabajador::findOrFail($id);
        return response()->json($registroHardware);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CuentaTrabajadorRequest $request, string $id)
    {
        $registroHardware = CuentaTrabajador::findOrFail($id);
        $registroHardware->update($request->validated());
        return response()->json($registroHardware, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registroHardware = CuentaTrabajador::findOrFail($id);
        $registroHardware->delete();
        return response()->noContent();
    }
}
