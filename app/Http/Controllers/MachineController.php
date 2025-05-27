<?php

namespace App\Http\Controllers;

use App\Http\Requests\MachineRequest;
use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Machine::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MachineRequest $request)
    {
        $equipo = Machine::create($request->validated());
        return response()->json($equipo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipo = Machine::findOrFail($id);
        return response()->json($equipo);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MachineRequest $request, string $id)
    {
        $equipo = Machine::findOrFail($id);
        $equipo->update($request->validated());
        return response()->json($equipo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipo = Machine::findOrFail($id);
        $equipo->delete();
        return response()->noContent();
    }

}
