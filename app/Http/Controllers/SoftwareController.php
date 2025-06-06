<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoftwareRequest;
use App\Models\Software;
use Illuminate\Http\Request;

class SoftwareController extends PermissionController
{
    public function __construct(){
        $this->permisos('Software');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Software::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SoftwareRequest $request)
    {
        $software = Software::create($request->validated());
        return response()->json($software, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $software = Software::findOrFail($id);
        return response()->json($software);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SoftwareRequest $request, string $id)
    {
        $software = Software::findOrFail($id);
        $software->update($request->validated());
        return response()->json($software, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $software = Software::findOrFail($id);
        $software->delete();
        return response()->noContent();
    }
}
