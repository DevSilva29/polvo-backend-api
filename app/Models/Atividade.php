<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Atividade extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'descricao', 'icone'];

    public function photos(): HasMany
    {
        return $this->hasMany(AtividadePhoto::class, 'atividade_id');
    }
}
