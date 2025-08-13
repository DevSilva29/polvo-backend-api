<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsgContato extends Model
{
    use HasFactory;

    protected $table = 'msgcontato';
    protected $primaryKey = 'msgContato_id';
    public $timestamps = false;

    protected $fillable = [
        'msgContato_name',
        'msgContato_lastname',
        'msgContato_email',
        'msgContato_phone',
        'msgContato_adress',
        'msgContato_type',
        'msgContato_msg',
        'msgContato_read',
    ];

    public function getRouteKeyName()
    {
        return 'msgContato_id';
    }
}