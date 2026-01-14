<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriquePrix extends Model
{
    use HasFactory;

    protected $table = 'historique_prix';
    protected $primaryKey = 'id_historique';
    public $timestamps = false;

    protected $fillable = [
        'id_produit',
        'prix_achat',
        'prix_vente',
        'date_debut',
        'date_fin',
    ];

    protected $dates = ['date_debut', 'date_fin'];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
}
