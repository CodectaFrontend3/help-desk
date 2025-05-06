<?php

namespace App\Http\Controllers;

use App\Models\ContactosRef;
use Illuminate\Http\Request;

class ContactosRefController extends Controller
{
    public function index()
    {
        return response()->json(ContactoRef::all());
    }

    // Crear un nuevo registro
    public function store(ContactoRefRequest $request)
    {
        $contactoRef = ContactoRef::create($validatedData);

        return response()->json($contactoRef, 201);
    }

    // Mostrar un registro específico
    public function show($id)
    {
        $contactoRef = ContactoRef::findOrFail($id);
        return response()->json($contactoRef);
    }

    // Actualizar un registro
    public function update(ContactoRefRequest $request, $id)
    {

        $contactoRef = ContactoRef::findOrFail($id);
        $contactoRef->update($request->validated());
        return response()->json($contactoRef, 200);
    }

    // Eliminar un registro
    public function destroy($id)
    {
        $contactoRef = ContactoRef::findOrFail($id);
        $contactoRef->delete();

        return response()->noContent();
    }
}
