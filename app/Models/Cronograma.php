<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    use HasFactory;

    protected $table = 'cronograma';

    protected $primaryKey = 'cronograma_id';

    public $timestamps = true;

    protected $fillable = [
        'cronograma_file',
    ];

    public function getRouteKeyName()
    {
        return 'cronograma_id';
    }
}