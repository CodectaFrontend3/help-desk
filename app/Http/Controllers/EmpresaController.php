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

    public function store(EmpresaRequest $request)
    {
        
        $empresa = Empresa::create($request->validated());
        return response()->json($empresa, 201);
    }

    public function show(string $id)
    {
        $empresa = Empresa::findOrFail($id);
        return response()->json($empresa);
    }

    public function update(EmpresaRequest $request, string $id)
    {
        
        $empresa = Empresa::findOrFail($id);
        $empresa->update($request->validated()); 
        return response()->json($empresa, 204);
    }

    public function destroy(string $id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();
        return response()->noContent();
    }
}
