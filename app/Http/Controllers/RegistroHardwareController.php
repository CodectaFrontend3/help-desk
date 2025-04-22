<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistroHardwareRequest;
use App\Models\RegistroHardware;
use Illuminate\Http\Request;

class RegistroHardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(RegistroHardware::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistroHardwareRequest $request)
    {
        $registroHardware = RegistroHardware::create($request->validated());
        return response()->json($registroHardware, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $registroHardware = RegistroHardware::findOrFail($id);
        return response()->json($registroHardware);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegistroHardwareRequest $request, string $id)
    {
        $registroHardware = RegistroHardware::findOrFail($id);
        $registroHardware->update($request->validated());
        return response()->json($registroHardware, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registroHardware = RegistroHardware::findOrFail($id);
        $registroHardware->delete();
        return response()->noContent();
    }
}
