<?php

namespace App\Http\Controllers;

use App\Models\MicroEmpresa;
use Illuminate\Http\Request;
use App\Http\Requests\MicroEmpresaRequest;

class MicroEmpresaController extends Controller
{
    public function index()
    {
        return response()->json(MicroEmpresa::all());
    }

    public function store(MicroEmpresaRequest $request)
    {
        $microempresa = MicroEmpresa::create($request->validated());
        return response()->json($microempresa, 201);
    }

    public function show(string $id)
    {
        $microempresa = MicroEmpresa::findOrFail($id);
        return response()->json($microempresa);
    }

    public function update(MicroEmpresaRequest $request, string $id)
    {
        $microempresa = MicroEmpresa::findOrFail($id);
        $microempresa->update($request->validated());
        return response()->json($microempresa, 200);
    }

    public function destroy(string $id)
    {
        $microempresa = MicroEmpresa::findOrFail($id);
        $microempresa->delete();
        return response()->noContent();
    }
}
