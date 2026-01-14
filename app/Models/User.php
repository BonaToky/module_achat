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

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_client', 'id_users');
    }

    public function livraisons()
    {
        return $this->hasMany(Livraison::class, 'livreur_id', 'id_users');
    }
}
