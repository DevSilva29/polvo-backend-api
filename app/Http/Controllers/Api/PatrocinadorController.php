<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PatrocinadorController extends Controller
{
    public function index()
    {
        // Busca todos os patrocinadores usando o Query Builder
        $patrocinadores = DB::table('patrocinadores')->get();

        // Formata os dados manualmente para garantir as URLs corretas
        $formatted = $patrocinadores->map(function ($item) {
            return [
                'id' => $item->patrocinadores_id,
                'name' => $item->patrocinadores_name,
                'url' => $item->patrocinadores_url,
                'logo' => $item->patrocinadores_logo ? Storage::disk('public_uploads')->url($item->patrocinadores_logo) : null,
            ];
        });

        return response()->json(['data' => $formatted]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patrocinadores_name' => 'required|string|max:255',
            'patrocinadores_url' => 'required|url',
            'patrocinadores_logo' => 'required|image|max:10240', // Aumentado para 10MB
        ]);

        $path = $request->file('patrocinadores_logo')->store('patrocinadores', 'public_uploads');

        try {
            // Insere e recupera o ID gerado
            $id = DB::table('patrocinadores')->insertGetId([
                'patrocinadores_name' => $validatedData['patrocinadores_name'],
                'patrocinadores_url' => $validatedData['patrocinadores_url'],
                'patrocinadores_logo' => $path,
                // Se a tabela tiver timestamps, descomente as linhas abaixo:
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ]);

            // Busca o registo recém-criado usando a chave correta
            $novoPatrocinador = DB::table('patrocinadores')->where('patrocinadores_id', $id)->first();

            // Formata a resposta
            $response = [
                'id' => $novoPatrocinador->patrocinadores_id,
                'name' => $novoPatrocinador->patrocinadores_name,
                'url' => $novoPatrocinador->patrocinadores_url,
                'logo' => Storage::disk('public_uploads')->url($novoPatrocinador->patrocinadores_logo),
            ];

            return response()->json(['data' => $response], 201);

        } catch (\Exception $e) {
            // Se der erro no banco, apaga a imagem para não deixar lixo
            Storage::disk('public_uploads')->delete($path);
            return response()->json(['message' => 'Erro ao salvar no banco.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        // Busca usando a chave correta
        $patrocinador = DB::table('patrocinadores')->where('patrocinadores_id', $id)->first();

        if (!$patrocinador) {
            return response()->json(['message' => 'Patrocinador não encontrado.'], 404);
        }

        $validatedData = $request->validate([
            'patrocinadores_name' => 'required|string|max:255',
            'patrocinadores_url' => 'required|url',
            'patrocinadores_logo' => 'nullable|image|max:10240',
        ]);

        $updateData = [
            'patrocinadores_name' => $validatedData['patrocinadores_name'],
            'patrocinadores_url' => $validatedData['patrocinadores_url'],
            // 'updated_at' => now(), // Descomente se tiver timestamps
        ];

        if ($request->hasFile('patrocinadores_logo')) {
            if ($patrocinador->patrocinadores_logo) {
                Storage::disk('public_uploads')->delete($patrocinador->patrocinadores_logo);
            }
            $path = $request->file('patrocinadores_logo')->store('patrocinadores', 'public_uploads');
            $updateData['patrocinadores_logo'] = $path;
        }

        DB::table('patrocinadores')->where('patrocinadores_id', $id)->update($updateData);

        // Retorna o dado atualizado
        $patrocinadorAtualizado = DB::table('patrocinadores')->where('patrocinadores_id', $id)->first();
        
        $response = [
            'id' => $patrocinadorAtualizado->patrocinadores_id,
            'name' => $patrocinadorAtualizado->patrocinadores_name,
            'url' => $patrocinadorAtualizado->patrocinadores_url,
            'logo' => Storage::disk('public_uploads')->url($patrocinadorAtualizado->patrocinadores_logo),
        ];

        return response()->json(['data' => $response]);
    }

    public function destroy(string $id)
    {
        $patrocinador = DB::table('patrocinadores')->where('patrocinadores_id', $id)->first();

        if ($patrocinador) {
            if ($patrocinador->patrocinadores_logo) {
                Storage::disk('public_uploads')->delete($patrocinador->patrocinadores_logo);
            }
            DB::table('patrocinadores')->where('patrocinadores_id', $id)->delete();
        }

        return response()->json(null, 204);
    }
}