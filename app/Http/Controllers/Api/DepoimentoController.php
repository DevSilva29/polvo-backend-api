<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Depoimento;
use Illuminate\Http\Request;
use App\Http\Resources\DepoimentoResource;
use Illuminate\Support\Facades\Storage;

class DepoimentoController extends Controller
{
    public function index()
    {
        return DepoimentoResource::collection(Depoimento::latest('depoimentos_id')->get());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'depoimentos_name' => 'required|string|max:255',
            'depoimentos_role' => 'nullable|string|max:255',
            'depoimentos_message' => 'required|string',
            'depoimentos_photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $path = $request->file('depoimentos_photo')->store('depoimentos', 'public_uploads');
        $validatedData['depoimentos_photo'] = $path;

        $depoimento = Depoimento::create($validatedData);

        return new DepoimentoResource($depoimento);
    }

    public function update(Request $request, Depoimento $depoimento)
    {
        $validatedData = $request->validate([
            'depoimentos_name' => 'required|string|max:255',
            'depoimentos_message' => 'required|string',
            'depoimentos_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Foto é opcional na atualização
        ]);

        if ($request->hasFile('depoimentos_photo')) {
            Storage::disk('public_uploads')->delete($depoimento->depoimentos_photo);
            $path = $request->file('depoimentos_photo')->store('depoimentos', 'public_uploads');
            $validatedData['depoimentos_photo'] = $path;
        }

        $depoimento->update($validatedData);

        return new DepoimentoResource($depoimento);
    }

    public function destroy(Depoimento $depoimento)
    {
        Storage::disk('public_uploads')->delete($depoimento->depoimentos_photo);

        $depoimento->delete();

        return response()->json(null, 204);
    }
}