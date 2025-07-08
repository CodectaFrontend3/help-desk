<?php

namespace App\Http\Controllers;

use App\Models\NaturalPerson;
use Illuminate\Http\Request;
use App\Http\Requests\NaturalPersonRequest;

class NaturalPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(NaturalPerson::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NaturalPersonRequest $request)
    {
        $naturalPerson = NaturalPerson::create($request->all());
        return response()->json($naturalPerson, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $naturalPerson = NaturalPerson::findOrFail($id);
        return response()->json($naturalPerson);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NaturalPersonRequest $request, string $id)
    {
        $naturalPerson = NaturalPerson::findOrFail($id);
        $naturalPerson->update($request->all());
        return response()->json($naturalPerson, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $naturalPerson = NaturalPerson::findOrFail($id);
        $naturalPerson->delete();
        return response()->noContent();
    }
    /**
     * buscar en cliente.
     */
    public function buscar(Request $request)
    {
        \Log::info('Request recibido:', $request->all());

        $query = $request->input('query');
        $tipo = $request->input('tipo');

        if ($tipo === 'nombre') {
            $resultados = NaturalPerson::where('name', 'like', "%{$query}%")->get();
        } elseif ($tipo === 'dni') {
            $resultados = NaturalPerson::where('dni', 'like', "%{$query}%")->get();
        } else {
            $resultados = NaturalPerson::where('name', 'like', "%{$query}%")
                ->orWhere('dni', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->get();
        }

        return response()->json($resultados);
    }
}
