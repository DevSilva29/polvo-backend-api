<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DepoimentoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->depoimentos_id,
            'author' => $this->depoimentos_name,
            'text' => $this->depoimentos_message,
            'image' => Storage::disk('public_uploads')->url($this->depoimentos_photo),
        ];
    }
}