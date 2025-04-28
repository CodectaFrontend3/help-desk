<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterHardwareRequest;
use App\Models\RegisterHardware;
use Illuminate\Http\Request;

class RegisterHardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(RegisterHardware::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterHardwareRequest $request)
    {
        $registerHardware = RegisterHardware::create($request->validated());
        return response()->json($registerHardware, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $registerHardware = RegisterHardware::findOrFail($id);
        return response()->json($registerHardware);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegisterHardwareRequest $request, string $id)
    {
        $registerHardware = RegisterHardware::findOrFail($id);
        $registerHardware->update($request->validated());
        return response()->json($registerHardware, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registerHardware = RegisterHardware::findOrFail($id);
        $registerHardware->delete();
        return response()->noContent();
    }

}
