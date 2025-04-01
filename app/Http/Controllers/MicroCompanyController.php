<?php

namespace App\Http\Controllers;

use App\Models\MicroCompany;
use Illuminate\Http\Request;

class MicroCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(MicroCompany::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $microCompany = MicroCompany::create($request->all());
        return response()->json($microCompany, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $microCompany = MicroCompany::findOrFail($id);
        return response()->json($microCompany);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $microCompany = MicroCompany::findOrFail($id);
        $microCompany->update($request->all());
        return response()->json($microCompany, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $microCompany = MicroCompany::findOrFail($id);
        $microCompany->delete();
        return response()->noContent();
    }
}
