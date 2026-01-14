<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categorie';
    protected $primaryKey = 'id_categorie';
    public $timestamps = false; // Pas de created_at/updated_at dans la table

    protected $fillable = [
        'libelle'
    ];

    // Relation avec les produits
    public function produits()
    {
        return $this->hasMany(Produit::class, 'id_categorie', 'id_categorie');
    }

    // Relation avec les mouvements de stock
    public function mouvementsStock()
    {
        return $this->hasMany(MouvementStock::class, 'id_categorie', 'id_categorie');
    }
}

