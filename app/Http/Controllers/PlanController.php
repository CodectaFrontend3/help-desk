<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanRequest;
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
    public function store(PlanRequest  $request)
    {
        $plan = Plan::create($request->validated());
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
    public function update(PlanRequest $request, string $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->update($request->validated());
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
        /**
     * buscar en Plan.
     */
    public function buscar(Request $request)
    {
        $query = $request->input('query');

        $resultados = Plan::where('plan_number', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();

        return response()->json($resultados);
    }
}
