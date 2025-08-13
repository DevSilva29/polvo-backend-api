<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage; // Garanta que esta importação existe

class AtividadeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->titulo,
            'description' => $this->descricao,

            // --- A CORREÇÃO ESTÁ AQUI ---
            // Usamos o Storage para gerar a URL pública completa para o ícone
            'icon' => $this->icone ? Storage::disk('public_uploads')->url($this->icone) : null,

            'photos' => AtividadePhotoResource::collection($this->whenLoaded('photos')),
        ];
    }
}