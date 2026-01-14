<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimiteStockProduit extends Model
{
    use HasFactory;

    protected $table = 'Limite_Stock_Produit';
    protected $primaryKey = 'id_stock';
    public $timestamps = false;

    protected $fillable = [
        'id_produit',
        'quantite_max',
        'date_debut',
        'date_fin',
    ];

    protected $dates = ['date_debut', 'date_fin'];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
}
