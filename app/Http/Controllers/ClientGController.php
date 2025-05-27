<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientGRequest;
use App\Models\ClientG;
use Illuminate\Http\Request;

class ClientGController extends Controller
{
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

        // Obtener todas las máquinas del cliente
        $machines = $client->machines;

        // Inicializar la variable de empresa/persona natural
        $empresa = null;
        $persona = null;

        foreach ($machines as $machine) {
            if ($machine->id_company) {
                $empresa = $machine->company; // relación en el modelo Machine
                break;
            } elseif ($machine->id_personN) {
                $persona = $machine->naturalPerson; // relación en el modelo Machine
                break;
            }
        }

        // Armar la respuesta
        if ($empresa) {
            $client->empresa_info = [
                'id_company' => $empresa->id,
                'client_name' => $empresa->client_name,
                'ruc' => $empresa->ruc,
                'address' => $empresa->address,
                'phone' => $empresa->phone,
                'email' => $empresa->email,
            ];
        } elseif ($persona) {
            $client->empresa_info = [
                'id_personN' => $persona->id,
                'dni' => $persona->dni,
                'name' => $persona->name,
                'email' => $persona->email,
                'phone' => $persona->phone,
            ];
        } else {
            $client->empresa_info = null;
        }

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
