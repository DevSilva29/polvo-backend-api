<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DocumentoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->docs_id,
            'title' => $this->docs_title,
            'number' => $this->docs_number,
            'date' => $this->docs_date->format('d/m/Y'),
            'type' => $this->docs_types,
            'file_url' => $this->docs_file ? Storage::disk('public_uploads')->url($this->docs_file) : null,
        ];
    }
}