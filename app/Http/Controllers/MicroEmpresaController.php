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

    public function store(Request $request)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'ruc' => 'required|string|max:11',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email|max:255',
        ]);

        $microempresa = MicroEmpresa::create($request->all());

        return response()->json($microempresa, 201);
    }

    public function show(MicroEmpresa $microempresa)
    {
        return $microempresa;
    }

    public function update(Request $request, MicroEmpresa $microempresa)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'ruc' => 'required|string|max:11',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'correo' => 'required|email|max:255',
        ]);

        $microempresa->update($request->all());

        return response()->noContent();
    }

    public function destroy(MicroEmpresa $microempresa)
    {
        $microempresa->delete();

        return response()->noContent();
    }
}
