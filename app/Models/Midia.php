<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midia extends Model
{
    use HasFactory;

    protected $table = 'midias';

    protected $primaryKey = 'midia_id';

    public $timestamps = false;

    protected $fillable = [
        'midia_title',
        'midia_link',
        'midia_platform',
        'midia_description',
    ];

    public function getRouteKeyName()
    {
        return 'midia_id';
    }
}