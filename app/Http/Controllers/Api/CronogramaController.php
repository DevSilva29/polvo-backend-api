<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cronograma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CronogramaController extends Controller
{
    public function getLatest()
    {
        $cronograma = Cronograma::latest('cronograma_id')->first();

        if (!$cronograma) {
            return response()->json(['message' => 'Nenhum cronograma encontrado.'], 404);
        }

        $url = Storage::disk('public_uploads')->url($cronograma->cronograma_file);

        return response()->json([
            'pdf_url' => $url
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        try {
            $newPath = $request->file('pdf_file')->store('cronogramas', 'public_uploads');

            $existingCronograma = Cronograma::latest('cronograma_id')->first();

            if ($existingCronograma) {
                $oldPath = $existingCronograma->cronograma_file;

                $existingCronograma->update(['cronograma_file' => $newPath]);

                Storage::disk('public_uploads')->delete($oldPath);

            } else {
                Cronograma::create(['cronograma_file' => $newPath]);
            }

            return response()->json(['message' => 'Cronograma atualizado com sucesso!'], 201);

        } catch (\Exception $e) {
            if (isset($newPath)) {
                Storage::disk('public_uploads')->delete($newPath);
            }
            return response()->json([
                'message' => 'Ocorreu um erro interno ao processar o arquivo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}