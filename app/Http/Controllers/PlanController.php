<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        return response()->json(Plan::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request  $request)
    {
        $request->validate([
            'numero_plan' => 'required|integer',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:2000'
        ]);
        $plan = Plan::create($request->all());
        return response()->json($plan, 201);
    }

    /**			
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plan = Plan::findOrFail($id);
        return response()->json($plan);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'numero_plan' => 'required|integer',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:2000'
        ]);
        $plan = Plan::findOrFail($id);
        $plan->update($request->all());
        return response()->json($plan, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return response()->noContent();
    }

}
