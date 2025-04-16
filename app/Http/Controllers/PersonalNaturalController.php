<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalNaturalRequest;
use App\Models\PersonalNatural;
use Illuminate\Http\Request;

class PersonalNaturalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(PersonalNatural::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonalNaturalRequest $request)
    {
        $personalNatural = PersonalNatural::create($request->validated());
        return response()->json($personalNatural, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $personalNatural = PersonalNatural::findOrFail($id);
        return response()->json($personalNatural);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonalNaturalRequest $request, string $id)
    {
        $personalNatural = PersonalNatural::findOrFail($id);
        $personalNatural->update($request->validated());
        return response()->json($personalNatural, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $personalNatural = PersonalNatural::findOrFail($id);
        $personalNatural->delete();
        return response()->noContent();
    }
}
