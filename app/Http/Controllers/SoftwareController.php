<?php

namespace App\Http\Controllers;

use App\Models\Software;
use Illuminate\Http\Request;

class SoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Software::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'licencia' => 'required|string',
            'correo' => 'required|email',
            'contraseña' => 'required|string',
            'proveedor' => 'required|string',
            'fecha_instalacion' => 'required|date',
            'fecha_caducidad' => 'required|date']);
        $software = Software::create($request->all());
        return response()->json($software, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $software = Software::findOrFail($id);
        return response()->json($software);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'licencia' => 'required|string',
            'correo' => 'required|email',
            'contraseña' => 'required|string',
            'proveedor' => 'required|string',
            'fecha_instalacion' => 'required|date',
            'fecha_caducidad' => 'required|date']);
        $software = Software::findOrFail($id);
        $software->update($request->all());
        return response()->json($software, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $software = Software::findOrFail($id);
        $software->delete();
        return response()->noContent();
    }
}
