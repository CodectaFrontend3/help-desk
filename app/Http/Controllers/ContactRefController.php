<?php

namespace App\Http\Controllers;

use App\Models\ContactRef;
use App\Http\Requests\ContactRefRequest;
use Illuminate\Http\Request;

class ContactRefController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = ContactRef::all();
        return response()->json($contacts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRefRequest $request)
    {

        $contact = ContactRef::create($request->validated());
        return response()->json($contact, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactRef $contactRef)
    {
        return response()->json($contactRef);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRefRequest $request, ContactRef $contactRef)
    {
        $contactRef->update($request->validated());
        return response()->json($contactRef);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactRef $contactRef)
    {
        $contactRef->delete();
        return response()->json(null, 204);
    }
}
