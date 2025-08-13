<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PresidenteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->presidentes_id,
            'name' => $this->presidentes_name,
            'role' => $this->presidentes_role,
            'term' => $this->presidentes_term,
            'photo_url' => Storage::disk('public_uploads')->url($this->presidentes_photo),
        ];
    }
}