<?php

namespace App\Http\Controllers;

use App\Models\MicroEmpresa;
use Illuminate\Http\Request;
use App\Http\Requests\MicroEmpresaRequest;

class MicroEmpresaController extends Controller
{
    public function index()
    {
        return MicroEmpresa::all();
    }

    public function store(MicroEmpresaRequest $request)
    {
       
        $microempresa = MicroEmpresa::create($request->validated());

        return response()->json($microempresa, 201);
    }

    public function show(MicroEmpresa $microempresa)
    {
        return $microempresa;
    }

    public function update(MicroEmpresaRequest $request, MicroEmpresa $microempresa)
    {
        $microempresa->update($request->validated());

        return response()->noContent();
    }

    public function destroy(MicroEmpresa $microempresa)
    {
        $microempresa->delete();

        return response()->noContent();
    }
}
