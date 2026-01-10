<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_users';

    protected $fillable = [
        'nom',
        'prenom',
        'numero',
        'password_hash',
        'adress',
        'solde',
        'id_role',
        'actif'
    ];

    protected $hidden = [
        'password_hash',
    ];

    // Laravel attend "password"
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
