<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    use HasFactory;

    protected $table = 'livraison';
    protected $primaryKey = 'id_livraison';
    public $timestamps = true;

    protected $fillable = [
        'id_ticket',
        'adresse_livraison',
        'statut_livraison',
        'date_livraison_prevue',
        'date_livraison_reelle',
        'livreur_id',
        'notes',
    ];

    protected $dates = ['date_livraison_prevue', 'date_livraison_reelle'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }

    public function livreur()
    {
        return $this->belongsTo(User::class, 'livreur_id', 'id_users');
    }
}
