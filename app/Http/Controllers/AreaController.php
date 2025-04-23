<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Requests\AreaRequest;

class AreaController extends Controller
{
    public function index()
    {
        return response()->json(Area::all());
    }

    public function store(AreaRequest $request)
    {
        $area = Area::create($request->all());
        return response()->json($area, 201);
    }

    public function show(string $id)
    {
        $area = Area::findOrFail($id);
        return response()->json($area);
    }

    public function update(AreaRequest $request, string $id)
    {
        $area = Area::findOrFail($id);
        $area->update($request->all());
        return response()->json($area, 204);
    }

    public function destroy(string $id)
    {
        $area = Area::findOrFail($id);
        $area->delete();
        return response()->noContent();
    }
}
