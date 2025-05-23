<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Requests\BranchRequest;

class BranchController extends PermissionController
{
    public function __construct(){
        $this->permisos('Branch');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Branch::with('company')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchRequest $request)
    {

        $branch = Branch::create($request->validated());
        return response()->json($branch, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $branch = Branch::with('company')->findOrFail($id);
        return response()->json($branch);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BranchRequest $request, string $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->update($request->validated());
        return response()->json($branch, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        return response()->noContent();
    }
}
