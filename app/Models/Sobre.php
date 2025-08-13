<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sobre extends Model
{
    use HasFactory;
    protected $table = 'sobre';
    protected $primaryKey = 'sobre_id';
    public $timestamps = false;
    protected $fillable = ['sobre_text', 'sobre_text2', 'sobre_photo'];
}