<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PatrocinadorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->patrocinadores_id,
            'name' => $this->patrocinadores_name,
            'url' => $this->patrocinadores_url,
            'logo' => Storage::disk('public_uploads')->url($this->patrocinadores_logo),
        ];
    }
}