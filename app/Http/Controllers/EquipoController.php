<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipoRequest;
use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Equipo::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquipoRequest $request)
    {
        $equipo = Equipo::create($request->validated());
        return response()->json($equipo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipo = Equipo::findOrFail($id);
        return response()->json($equipo);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EquipoRequest $request, string $id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->update($request->validated());
        return response()->json($equipo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();
        return response()->noContent();
    }

}
