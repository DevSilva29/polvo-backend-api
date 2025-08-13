<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // --- NOSSAS MUDANÇAS ---

    /**
     * A tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * A chave primária da tabela.
     *
     * @var string
     */
    protected $primaryKey = 'admins_id';

    public $timestamps = false;

    /**
     * O nome da coluna de "username".
     */
    const USERNAME = 'admins_user';

    /**
     * O nome da coluna de "password".
     */
    const PASSWORD = 'admins_password';

    /**
     * Os atributos que podem ser preenchidos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admins_user',
        'admins_password',
    ];

    /**
     * Os atributos que devem ser escondidos nas serializações.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'admins_password',
        'remember_token',
    ];

    /**
     * Sobrescreve o método para usar a nossa coluna de password.
     */
    public function getAuthPassword()
    {
        return $this->admins_password;
    }
}