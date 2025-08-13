<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MidiaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->midia_id,
            'title' => $this->midia_title,
            'description' => $this->midia_description,
            // A URL já vem no formato de embed correto do controller
            'embed_url' => $this->midia_link,
        ];
    }
}