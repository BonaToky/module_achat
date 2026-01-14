<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produit';
    protected $primaryKey = 'id_produit';
// <<<<<<< Bona
    
//     protected $fillable = [
//         'nom',
//         'image',
//         'id_categorie'
//     ];

//     protected $casts = [
//         'created_at' => 'datetime',
//         'updated_at' => 'datetime'
//     ];

//     // Relation avec la catégorie
//     public function categorie()
//     {
//         return $this->belongsTo(Categorie::class, 'id_categorie', 'id_categorie');
//     }

//     // Relation avec les mouvements de stock
//     public function mouvementsStock()
//     {
//         return $this->hasMany(MouvementStock::class, 'id_produit', 'id_produit');
//     }

//     // Méthode pour calculer le stock actuel (quantité totale)
//     public function stockActuel()
//     {
//         return $this->mouvementsStock()->sum('quantite');
//     }
// }
    public $timestamps = true;

    protected $fillable = [
        'nom',
        'image',
        'id_categorie',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    public function historiquePrix()
    {
        return $this->hasMany(HistoriquePrix::class, 'id_produit');
    }

    public function mouvementStocks()
    {
        return $this->hasMany(MouvementStock::class, 'id_produit');
    }

    public function detailsVentes()
    {
        return $this->hasMany(DetailsVente::class, 'id_produit');
    }

    public function getPrixActuelAttribute()
    {
        return $this->historiquePrix()->whereNull('date_fin')->first()->prix_vente ?? 0;
    }

    public function getStockActuelAttribute()
    {
        $entrees = $this->mouvementStocks()->where('type_mouvement_stock', 'entree')->sum('quantite');
        $sorties = $this->mouvementStocks()->where('type_mouvement_stock', 'sortie')->sum('quantite');
        return $entrees - $sorties;
    }
}
