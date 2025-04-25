<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistroCuentaRequest;
use App\Models\RegistroCuenta;
use Illuminate\Http\Request;

class RegistroCuentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(RegistroCuenta::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistroCuentaRequest $request)
    {
        $clienteG = RegistroCuenta::create($request->validated());
        return response()->json($clienteG, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $clienteG = RegistroCuenta::findOrFail($id);
        return response()->json($clienteG);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegistroCuentaRequest $request, string $id)
    {
        $clienteG = RegistroCuenta::findOrFail($id);
        $clienteG->update($request->validated());
        return response()->json($clienteG, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clienteG = RegistroCuenta::findOrFail($id);
        $clienteG->delete();
        return response()->noContent();
    }

}
