<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depoimento extends Model
{
    use HasFactory;

    protected $table = 'depoimentos';
    protected $primaryKey = 'depoimentos_id';

    protected $fillable = [
        'depoimentos_name',
        'depoimentos_message',
        'depoimentos_photo',
    ];
}