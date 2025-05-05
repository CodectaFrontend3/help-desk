<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoftwareTeamRequest;
use App\Models\SoftwareTeam;
use Illuminate\Http\Request;

class SoftwareTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(SoftwareTeam::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SoftwareTeamRequest $request)
    {
        $softwareEquipo = SoftwareTeam::create($request->validated());
        return response()->json($softwareEquipo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $softwareEquipo = SoftwareTeam::findOrFail($id);
        return response()->json($softwareEquipo);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SoftwareTeamRequest $request, string $id)
    {
        $softwareEquipo = SoftwareTeam::findOrFail($id);
        $softwareEquipo->update($request->validated());
        return response()->json($softwareEquipo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $softwareEquipo = SoftwareTeam::findOrFail($id);
        $softwareEquipo->delete();
        return response()->noContent();
    }

}
