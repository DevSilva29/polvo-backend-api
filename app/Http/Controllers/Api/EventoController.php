<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use App\Http\Resources\EventoResource;
use Illuminate\Support\Facades\Storage;

class EventoController extends Controller
{
    public function index()
    {
        return EventoResource::collection(Evento::latest('eventos_id')->get());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'eventos_title' => 'required|string|max:255',
            'eventos_description' => 'required|string',
            'eventos_date' => 'required|date',
            'eventos_photo' => 'required|image|max:2048', // Validação para a foto
        ]);

        $path = $request->file('eventos_photo')->store('eventos', 'public_uploads');
        $validatedData['eventos_photo'] = $path;

        $evento = Evento::create($validatedData);
        return new EventoResource($evento);
    }

    public function update(Request $request, Evento $evento)
    {
        $validatedData = $request->validate([
            'eventos_title' => 'required|string|max:255',
            'eventos_description' => 'required|string',
            'eventos_date' => 'required|date',
            'eventos_photo' => 'nullable|image|max:2048', // Foto é opcional na atualização
        ]);

        if ($request->hasFile('eventos_photo')) {
            if ($evento->eventos_photo) {
                Storage::disk('public_uploads')->delete($evento->eventos_photo);
            }
            $path = $request->file('eventos_photo')->store('eventos', 'public_uploads');
            $validatedData['eventos_photo'] = $path;
        }

        $evento->update($validatedData);
        return new EventoResource($evento);
    }

    public function destroy(Evento $evento)
    {
        if ($evento->eventos_photo) {
            Storage::disk('public_uploads')->delete($evento->eventos_photo);
        }
        $evento->delete();
        return response()->json(null, 204);
    }
}