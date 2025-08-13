<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Midia;
use Illuminate\Http\Request;
use App\Http\Resources\MidiaResource;
use Illuminate\Validation\Rule;

class MidiaController extends Controller
{
    /**
     * Função universal para extrair o ID de qualquer tipo de link do YouTube.
     * Ela entende formatos como:
     * - youtube.com/watch?v=...33
     * - youtube.com/watch?v=...34
     * - O seu link de live do Cloud Workstations
     */
    private function getYouTubeIdFromUrl($url)
    {
        // Regex que captura o ID de múltiplos formatos de link
        $regex = '/(youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|googleusercontent\.com\/youtube\.com\/live\/)([^"&?\/ ]{11})/';
        if (preg_match($regex, $url, $match)) {
            return $match[2]; // Retorna o ID do vídeo
        }

        return null;
    }

    private function getVimeoVideoId($url)
    {
        preg_match('/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/', $url, $match);
        return $match[5] ?? null;
    }

    public function index()
    {
        return MidiaResource::collection(Midia::latest('midia_id')->get());
    }

    /**
     * Função centralizada que valida, converte a URL e salva no banco.
     */
    private function processAndSave(Request $request, Midia $midia = null)
    {
        $validatedData = $request->validate([
            'midia_title' => 'required|string|max:255',
            'midia_link' => 'required|string', // Apenas verificamos se é um texto
            'midia_platform' => ['required', Rule::in(['youtube', 'vimeo'])],
            'midia_description' => 'nullable|string',
        ]);

        $finalEmbedUrl = null;
        $originalLink = $validatedData['midia_link'];

        if ($validatedData['midia_platform'] === 'youtube') {
            $videoId = $this->getYouTubeIdFromUrl($originalLink);
            if ($videoId) {
                // Sempre construímos a URL de embed padrão e segura
                $finalEmbedUrl = 'https://www.youtube.com/embed/' . $videoId;
            }
        } elseif ($validatedData['midia_platform'] === 'vimeo') {
            $videoId = $this->getVimeoVideoId($originalLink);
            if ($videoId) {
                $finalEmbedUrl = 'https://player.vimeo.com/video/' . $videoId;
            }
        }

        // Se, depois de tudo, não conseguimos uma URL de embed, retorna erro.
        if (!$finalEmbedUrl) {
            return response()->json([
                'message' => 'O link fornecido não parece ser um URL de vídeo válido do YouTube ou Vimeo.',
                'errors' => ['midia_link' => ['Verifique o link e tente novamente.']]
            ], 422);
        }
        
        // Prepara os dados para salvar, com a URL já convertida e correta
        $saveData = $validatedData;
        $saveData['midia_link'] = $finalEmbedUrl;

        if ($midia) { // Se estamos a atualizar
            $midia->update($saveData);
            return new MidiaResource($midia);
        } else { // Se estamos a criar
            $newMidia = Midia::create($saveData);
            return new MidiaResource($newMidia);
        }
    }

    public function store(Request $request)
    {
        return $this->processAndSave($request);
    }

    public function update(Request $request, Midia $midia)
    {
        return $this->processAndSave($request, $midia);
    }

    public function destroy(Midia $midia)
    {
        $midia->delete();
        return response()->json(null, 204);
    }
}