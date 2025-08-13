<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['gallery_id', 'path', 'caption'];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(PhotoGallery::class, 'gallery_id');
    }
}