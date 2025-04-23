<?php

namespace App\Http\Controllers;

use App\Models\PersonaNatural;
use Illuminate\Http\Request;
use App\Http\Requests\PersonaNaturalRequest;

class PersonaNaturalController extends Controller
{
    public function index()
    {
        return response()->json(PersonaNatural::all());
    }

    public function store(PersonaNaturalRequest $request)
    {
        $persona = PersonaNatural::create($request->validated());
        return response()->json($persona, 201);
    }

    public function show(string $id)
    {
        $persona = PersonaNatural::findOrFail($id);
        return response()->json($persona);
    }

    public function update(PersonaNaturalRequest $request, string $id)
    {
        $persona = PersonaNatural::findOrFail($id);
        $persona->update($request->validated());
        return response()->json($persona, 200);
    }

    public function destroy(string $id)
    {
        $persona = PersonaNatural::findOrFail($id);
        $persona->delete();
        return response()->noContent();
    }
}
