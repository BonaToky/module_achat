<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouvementStock extends Model
{
    use HasFactory;

    protected $table = 'mouvement_stock';
    protected $primaryKey = 'id_mouvement_stock';
    
    // Le champ 'date_mouv' est utilisé comme timestamp
    const CREATED_AT = 'date_mouv';
    const UPDATED_AT = null; // Pas de updated_at

    protected $fillable = [
        'type_mouvement_stock',
        'quantite',
        'id_categorie',
        'id_produit'
    ];

    protected $casts = [
        'date_mouv' => 'datetime',
        'quantite' => 'integer'
    ];

    // Relation avec la catégorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie', 'id_categorie');
    }

    // Relation avec le produit
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit', 'id_produit');
    }

    // Scope pour les entrées de stock (si quantite > 0)
    public function scopeEntrees($query)
    {
        return $query->where('quantite', '>', 0);
    }

    // Scope pour les sorties de stock (si quantite < 0)
    public function scopeSorties($query)
    {
        return $query->where('quantite', '<', 0);
    }
}