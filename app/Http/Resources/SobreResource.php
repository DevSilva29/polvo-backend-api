<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SobreResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'text1' => $this->sobre_text,
            'text2' => $this->sobre_text2,
            'team_photo_url' => Storage::disk('public_uploads')->url($this->sobre_photo),
        ];
    }
}