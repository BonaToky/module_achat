<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produit';
    protected $primaryKey = 'id_produit';
    public $timestamps = true;
    public $incrementing = true; // Assure que c'est un auto-increment

    protected $fillable = [
        'nom',
        'image',
        'id_categorie',
        'stock_actuel', // Ajouté car dans la migration il a une valeur par défaut
    ];

    protected $appends = ['prix_actuel', 'stock_calcule']; // Stock calculé renommé pour éviter conflit

    /**
     * Relation avec la catégorie
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie', 'id_categorie');
    }

    /**
     * Historique des prix
     */
    public function historiquePrix()
    {
        return $this->hasMany(HistoriquePrix::class, 'id_produit');
    }

    /**
     * Mouvements de stock
     */
    public function mouvementStocks()
    {
        return $this->hasMany(MouvementStock::class, 'id_produit');
    }

    /**
     * Détails des ventes
     */
    public function detailsVentes()
    {
        return $this->hasMany(DetailsVente::class, 'id_produit');
    }

    /**
     * Accesseur pour le prix actuel
     */
    public function getPrixActuelAttribute()
    {
        $prixActuel = $this->historiquePrix()
            ->whereNull('date_fin')
            ->orderBy('date_debut', 'desc')
            ->first();
            
        return $prixActuel ? $prixActuel->prix_vente : 0;
    }

    /**
     * Accesseur pour le stock calculé (renommé pour éviter conflit avec stock_actuel)
     */
    public function getStockCalculeAttribute()
    {
        $entrees = $this->mouvementStocks()
            ->where('type_mouvement_stock', 'entree')
            ->sum('quantite');
            
        $sorties = $this->mouvementStocks()
            ->where('type_mouvement_stock', 'sortie')
            ->sum('quantite');
            
        return $entrees - $sorties;
    }

}