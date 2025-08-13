<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhotoGallery extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class, 'gallery_id');
    }
}