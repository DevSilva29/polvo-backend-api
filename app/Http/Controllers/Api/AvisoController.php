<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aviso;
use Illuminate\Http\Request;

class AvisoController extends Controller
{
    public function index()
    {
        return Aviso::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'avisos_title' => 'required|string|max:255',
            'avisos_description' => 'required|string',
        ]);

        $aviso = Aviso::create($validatedData);

        return response()->json($aviso, 201);
    }

    public function show(Aviso $aviso)
    {
        return $aviso;
    }

    public function update(Request $request, Aviso $aviso)
    {
        $validatedData = $request->validate([
            'avisos_title' => 'required|string|max:255',
            'avisos_description' => 'required|string',
        ]);

        $aviso->update($validatedData);

        return response()->json($aviso);
    }

    public function destroy(Aviso $aviso)
    {
        $aviso->delete();

        return response()->json(null, 204);
    }
}