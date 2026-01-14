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
