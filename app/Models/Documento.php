<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'docs';
    protected $primaryKey = 'docs_id';
    public $timestamps = false;

    protected $fillable = [
        'docs_title',
        'docs_number',
        'docs_date',
        'docs_types',
        'docs_file',
    ];

    protected $casts = [
        'docs_date' => 'date',
    ];

    /**
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'docs_id';
    }
}