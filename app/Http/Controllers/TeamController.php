<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Team::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamRequest $request)
    {
        $equipo = Team::create($request->validated());
        return response()->json($equipo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipo = Team::findOrFail($id);
        return response()->json($equipo);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamRequest $request, string $id)
    {
        $equipo = Team::findOrFail($id);
        $equipo->update($request->validated());
        return response()->json($equipo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipo = Team::findOrFail($id);
        $equipo->delete();
        return response()->noContent();
    }


}
