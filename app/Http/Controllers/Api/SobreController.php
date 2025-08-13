<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sobre;
use Illuminate\Http\Request;
use App\Http\Resources\SobreResource;
use Illuminate\Support\Facades\Storage;

class SobreController extends Controller
{
    public function show()
    {
        $sobre = Sobre::firstOrCreate(
            ['sobre_id' => 1],
            [
                'sobre_text' => 'Bem-vindo! Edite este texto no seu painel.',
                'sobre_text2' => 'Adicione mais informações aqui.',
                'sobre_photo' => '' 
            ]
        );
        return new SobreResource($sobre);
    }

    /**
     * Atualiza (ou cria) o conteúdo da página Sobre.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'sobre_text' => 'required|string',
            'sobre_text2' => 'required|string',
            'sobre_photo' => 'nullable|image|max:2048',
        ]);

        $sobre = Sobre::first();

        if ($request->hasFile('sobre_photo')) {
            if ($sobre && $sobre->sobre_photo) {
                Storage::disk('public_uploads')->delete($sobre->sobre_photo);
            }
            $path = $request->file('sobre_photo')->store('sobre', 'public_uploads');
            $validatedData['sobre_photo'] = $path;
        }

        $updatedSobre = Sobre::updateOrCreate(
            ['sobre_id' => 1],
            $validatedData
        );

        return new SobreResource($updatedSobre);
    }
}