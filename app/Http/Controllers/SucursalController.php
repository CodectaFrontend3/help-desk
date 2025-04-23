<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sucursal;
use App\Http\Requests\SucursalRequest;

class SucursalController extends Controller
{
    public function index()
    {
        return response()->json(Sucursal::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SucursalRequest $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresa,id',
            'nombre_sucursal' => 'required|string|max:255',
            'encargado' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
        ]);

        $sucursal = Sucursal::create($request->all());
        return response()->json($sucursal, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sucursal = Sucursal::findOrFail($id);
        return response()->json($sucursal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SucursalRequest $request, string $id)
    {
        $request->validate([
            'nombre_sucursal' => 'required|string|max:255',
            'encargado' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
        ]);
    
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->update($request->all());
        return response()->json($sucursal, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->delete();
        return response()->noContent();
    }
}
