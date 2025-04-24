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

    public function store(SucursalRequest $request)
    {
        
        $sucursal = Sucursal::create($request->validated());
        return response()->json($sucursal, 201);
    }

    public function show(string $id)
    {
        $sucursal = Sucursal::findOrFail($id);
        return response()->json($sucursal);
    }

    public function update(SucursalRequest $request, string $id)
    {
        
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->update($request->validated());
        return response()->json($sucursal, 204);
    }

    public function destroy(string $id)
    {
        $sucursal = Empresa::findOrFail($id);
        $sucursal->delete();
        return response()->noContent();
    }
}
