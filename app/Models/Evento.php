<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    protected $primaryKey = 'eventos_id';
    public $timestamps = false;

    protected $fillable = [
        'eventos_title',
        'eventos_description',
        'eventos_date',
        'eventos_photo',
    ];

    protected $casts = [
        'eventos_date' => 'date',
    ];
}