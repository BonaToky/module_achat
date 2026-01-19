<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    use HasFactory;

    protected $table = 'livraisons';
    protected $primaryKey = 'id_livraison';

    protected $fillable = [
        'id_ticket',
        'adresse_livraison',
        'statut_livraison',
        'date_livraison_prevue',
        'date_livraison_reelle',
        'livreur_id',
        'notes'
    ];

    // Relations
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket');
    }

    public function livreur()
    {
        return $this->belongsTo(User::class, 'livreur_id', 'id_users');
    }
}
