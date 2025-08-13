<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage; // <-- A LINHA QUE FALTAVA

class EventoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->eventos_id,
            'title' => $this->eventos_title,
            'description' => $this->eventos_description,
            'date' => optional($this->eventos_date)->format('d/m/Y'),
            'icon' => $this->eventos_icon,
            // A propriedade 'photo_url' que o controller novo usa
            'photo_url' => $this->eventos_photo ? Storage::disk('public_uploads')->url($this->eventos_photo) : null,
        ];
    }
}