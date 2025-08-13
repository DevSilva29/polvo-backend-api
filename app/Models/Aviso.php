<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    use HasFactory;

    protected $table = 'avisos';
    protected $primaryKey = 'avisos_id';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'avisos_title',
        'avisos_description',
    ];

    public function getRouteKeyName()
    {
        return 'avisos_id';
    }
}