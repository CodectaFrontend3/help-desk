<?php

namespace App\Http\Controllers;

use App\Http\Requests\HardwareRequest;
use App\Models\Hardware;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Hardware::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HardwareRequest $request)
    {
        $registroHardware = Hardware::create($request->validated());
        return response()->json($registroHardware, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $registroHardware = Hardware::findOrFail($id);
        return response()->json($registroHardware);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HardwareRequest $request, string $id)
    {
        $registroHardware = Hardware::findOrFail($id);
        $registroHardware->update($request->validated());
        return response()->json($registroHardware, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registroHardware = Hardware::findOrFail($id);
        $registroHardware->delete();
        return response()->noContent();
    }

}
