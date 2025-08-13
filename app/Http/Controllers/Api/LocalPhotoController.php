<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LocalPhoto;
use Illuminate\Http\Request;
use App\Http\Resources\LocalPhotoResource;
use Illuminate\Support\Facades\Storage;

class LocalPhotoController extends Controller
{
    public function index(){
        return LocalPhotoResource::collection(LocalPhoto::all());
    }
    public function store(Request $request) {
        $validatedData = $request->validate ([
            'photos' => 'required|array',
            'photos.*' => 'image|max:5120',
        ]);
        foreach ($request->file('photos') as $photoFile) {
            $path = $photoFile->store('local', 'public_uploads');
            LocalPhoto::create (['path' => $path]);
        }
        return response()->json(['message' => 'Fotos do local adicionadas com sucesso!'], 201);
    }

    public function destroy(LocalPhoto $photo) {
        Storage::disk ('public_uploads')->delete ($photo->path);
        $photo->delete();
        return response()->json(['message' => 'Foto do local removida com sucesso!'], 200);
    }
}
