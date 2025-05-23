<?php

namespace App\Http\Controllers;

use App\Models\AccountRegister;
use App\Http\Requests\AccountRegisterRequest;
use Illuminate\Http\Request;

class AccountRegisterController extends PermissionController
{
    public function __construct(){
        $this->permisos('AccountRegister');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(AccountRegister::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRegisterRequest $request)
    {
        $accountRegister = AccountRegister::create($request->validated());
        return response()->json($accountRegister, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $accountRegister = AccountRegister::findOrFail($id);
        return response()->json($accountRegister);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountRegisterRequest $request, string $id)
    {
        $accountRegister = AccountRegister::findOrFail($id);
        $accountRegister->update($request->validated());
        return response()->json($accountRegister, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accountRegister = AccountRegister::findOrFail($id);
        $accountRegister->delete();
        return response()->noContent();
    }
}
