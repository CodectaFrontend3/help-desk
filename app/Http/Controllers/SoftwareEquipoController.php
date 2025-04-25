<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoftwareEquipoRequest;
use App\Models\SoftwareEquipo;
use Illuminate\Http\Request;

class SoftwareEquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(SoftwareEquipo::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SoftwareEquipoRequest $request)
    {
        $softwareEquipo = SoftwareEquipo::create($request->validated());
        return response()->json($softwareEquipo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $softwareEquipo = SoftwareEquipo::findOrFail($id);
        return response()->json($softwareEquipo);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SoftwareEquipoRequest $request, string $id)
    {
        $softwareEquipo = SoftwareEquipo::findOrFail($id);
        $softwareEquipo->update($request->validated());
        return response()->json($softwareEquipo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $softwareEquipo = SoftwareEquipo::findOrFail($id);
        $softwareEquipo->delete();
        return response()->noContent();
    }

}
