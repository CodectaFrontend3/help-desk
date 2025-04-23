<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaRequest;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        return response()->json(Empresa::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmpresaRequest $request)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'ruc' => 'required|string|max:11',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email|max:255',
        ]);

        $empresa = Empresa::create($request->all());
        return response()->json($empresa, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $empresa = Empresa::findOrFail($id);
        return response()->json($empresa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmpresaRequest $request, string $id)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'ruc' => 'required|string|max:11',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email|max:255',
        ]);

        $empresa = Empresa::findOrFail($id);
        $empresa->update($request->all());
        return response()->json($empresa, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();
        return response()->noContent();
    }
}
