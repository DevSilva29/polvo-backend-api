<?php

namespace App\Http\Controllers\Api; // O erro estava aqui

use App\Http\Controllers\Controller;
use App\Models\Atividade;
use App\Models\AtividadePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\AtividadePhotoResource;

class AtividadePhotoController extends Controller
{
    /**
     * Adiciona uma ou mais fotos a uma atividade existente.
     */
    public function store(Request $request, Atividade $atividade)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $photos = [];
        foreach ($request->file('photos') as $photoFile) {
            $path = $photoFile->store('atividades/photos', 'public_uploads');
            $photo = $atividade->photos()->create(['caminho_foto' => $path]);
            $photos[] = $photo;
        }

        return AtividadePhotoResource::collection($photos);
    }

    /**
     * Apaga uma foto específica.
     */
    public function destroy(AtividadePhoto $photo)
    {
        Storage::disk('public_uploads')->delete($photo->caminho_foto);
        $photo->delete();

        return response()->json(null, 204);
    }
}