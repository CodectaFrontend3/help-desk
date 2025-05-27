<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoftwareMachineRequest;
use App\Models\SoftwareMachine;
use Illuminate\Http\Request;

class SoftwareMachineController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(SoftwareMachine::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SoftwareMachineRequest $request)
    {
        $softwareEquipo = SoftwareMachine::create($request->validated());
        return response()->json($softwareEquipo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $softwareEquipo = SoftwareMachine::findOrFail($id);
        return response()->json($softwareEquipo);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SoftwareMachineRequest $request, string $id)
    {
        $softwareEquipo = SoftwareMachine::findOrFail($id);
        $softwareEquipo->update($request->validated());
        return response()->json($softwareEquipo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $softwareEquipo = SoftwareMachine::findOrFail($id);
        $softwareEquipo->delete();
        return response()->noContent();
    }
}
