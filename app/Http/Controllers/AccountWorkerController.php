<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountWorkerRequest;
use App\Models\AccountWorker;
use Illuminate\Http\Request;

class AccountWorkerController extends PermissionController
{
    public function __construct(){
        $this->permisos('AccountWorker');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(AccountWorker::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountWorkerRequest $request)
    {
        $registroHardware = AccountWorker::create($request->validated());
        return response()->json($registroHardware, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $registroHardware = AccountWorker::findOrFail($id);
        return response()->json($registroHardware);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountWorkerRequest $request, string $id)
    {
        $registroHardware = AccountWorker::findOrFail($id);
        $registroHardware->update($request->validated());
        return response()->json($registroHardware, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registroHardware = AccountWorker::findOrFail($id);
        $registroHardware->delete();
        return response()->noContent();
    }
}
