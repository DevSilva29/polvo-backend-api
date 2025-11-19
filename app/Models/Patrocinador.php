<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patrocinador extends Model
{
    use HasFactory;

    protected $table = 'patrocinadores';
    protected $primaryKey = 'patrocinadores_id';
    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'patrocinadores_name',
        'patrocinadores_logo',
        'patrocinadores_url',
    ];
}