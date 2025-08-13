<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Atividade;
use Illuminate\Http\Request;
use App\Http\Resources\AtividadeResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // Usaremos para transações

class AtividadeController extends Controller
{
    public function index()
    {
        $atividades = Atividade::with('photos')->latest()->get();
        return AtividadeResource::collection($atividades);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'icone' => 'required|file|mimes:svg,png,jpg,webp|max:1024',
            'photos' => 'nullable|array', // Agora aceita um array de fotos opcional
            'photos.*' => 'image|max:5120',
        ]);

        DB::beginTransaction();
        try {
            $path = $request->file('icone')->store('atividades/icons', 'public_uploads');
            $validatedData['icone'] = $path;

            $atividade = Atividade::create($validatedData);

            // Se o utilizador enviou fotos da galeria, guardamo-las
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photoFile) {
                    $photoPath = $photoFile->store('atividades/photos', 'public_uploads');
                    $atividade->photos()->create(['caminho_foto' => $photoPath]);
                }
            }

            DB::commit();
            return new AtividadeResource($atividade->load('photos'));

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao criar a atividade.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Atividade $atividade)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'icone' => 'nullable|file|mimes:svg,png,jpg,webp|max:1024',
        ]);

        if ($request->hasFile('icone')) {
            if ($atividade->icone) Storage::disk('public_uploads')->delete($atividade->icone);
            $path = $request->file('icone')->store('atividades/icons', 'public_uploads');
            $validatedData['icone'] = $path;
        }

        $atividade->update($validatedData);

        return new AtividadeResource($atividade);
    }

    public function destroy(Atividade $atividade)
    {
        if ($atividade->icone) Storage::disk('public_uploads')->delete($atividade->icone);
        foreach ($atividade->photos as $photo) {
            Storage::disk('public_uploads')->delete($photo->caminho_foto);
        }
        $atividade->delete();
        return response()->json(null, 204);
    }
}