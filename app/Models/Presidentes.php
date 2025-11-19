<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presidentes extends Model
{
    use HasFactory;
    protected $table = 'presidentes';
    protected $primaryKey = 'presidentes_id';
    public $timestamps = false;
    protected $fillable = ['presidentes_name', 'presidentes_role', 'presidentes_term', 'presidentes_photo'];
}
