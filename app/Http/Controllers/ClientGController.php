<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientGRequest;
use App\Models\ClientG;
use Illuminate\Http\Request;

class ClientGController extends PermissionController
{
    public function __construct(){
        $this->permisos('ClientG');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(ClientG::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientGRequest $request)
    {
        $client = ClientG::create($request->validated());
        return response()->json($client, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = ClientG::findOrFail($id);
        return response()->json($client);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientGRequest $request, string $id)
    {
        $client = ClientG::findOrFail($id);
        $client->update($request->validated());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = ClientG::findOrFail($id);
        $client->delete();
        return response()->noContent();
    }
}
