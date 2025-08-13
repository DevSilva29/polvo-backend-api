<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presidentes;
use Illuminate\Http\Request;
use App\Http\Resources\PresidenteResource;
use Illuminate\Support\Facades\Storage;

class PresidenteController extends Controller
{
    public function index()
    {
        return PresidenteResource::collection(Presidentes::all());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'presidentes_name' => 'required|string|max:255',
            'presidentes_role' => 'required|string|max:255',
            'presidentes_term' => 'required|string|max:255',
            'presidentes_photo' => 'required|image|max:2048',
        ]);

        $path = $request->file('presidentes_photo')->store('presidentes', 'public_uploads');
        $validatedData['presidentes_photo'] = $path;

        $presidente = Presidentes::create($validatedData);
        return new PresidenteResource($presidente);
    }

    public function update(Request $request, Presidentes $presidente)
    {
        $validatedData = $request->validate([
            'presidentes_name' => 'required|string|max:255',
            'presidentes_role' => 'required|string|max:255',
            'presidentes_term' => 'required|string|max:255',
            'presidentes_photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('presidentes_photo')) {
            Storage::disk('public_uploads')->delete($presidente->presidentes_photo);
            $path = $request->file('presidentes_photo')->store('presidentes', 'public_uploads');
            $validatedData['presidentes_photo'] = $path;
        }

        $presidente->update($validatedData);
        return new PresidenteResource($presidente);
    }

    public function destroy(Presidentes $presidente)
    {
        Storage::disk('public_uploads')->delete($presidente->presidentes_photo);
        $presidente->delete();
        return response()->json(null, 204);
    }
}