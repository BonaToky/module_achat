<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produit';
    protected $primaryKey = 'id_produit';
    
    protected $fillable = [
        'nom',
        'image',
        'id_categorie'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relation avec la catégorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie', 'id_categorie');
    }

    // Relation avec les mouvements de stock
    public function mouvementsStock()
    {
        return $this->hasMany(MouvementStock::class, 'id_produit', 'id_produit');
    }

    // Méthode pour calculer le stock actuel (quantité totale)
    public function stockActuel()
    {
        return $this->mouvementsStock()->sum('quantite');
    }
}