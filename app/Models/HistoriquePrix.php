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
        'date_fin'
    ];

    protected $casts = [
        'prix_achat' => 'decimal:2',
        'prix_vente' => 'decimal:2',
        'date_debut' => 'datetime',
        'date_fin' => 'datetime'
    ];

    // Relation avec le produit
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit', 'id_produit');
    }

    // Scope pour les prix actifs (sans date_fin)
    public function scopeActif($query)
    {
        return $query->whereNull('date_fin');
    }

    // Scope pour les prix historiques (avec date_fin)
    public function scopeHistorique($query)
    {
        return $query->whereNotNull('date_fin');
    }

    // Méthode pour clôturer un prix (mettre date_fin)
    public function cloturer()
    {
        $this->date_fin = now();
        return $this->save();
    }

    // Accessor pour le statut
    public function getStatutAttribute()
    {
        return is_null($this->date_fin) ? 'Actif' : 'Historique';
    }
}