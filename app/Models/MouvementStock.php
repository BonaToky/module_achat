<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouvementStock extends Model
{
    use HasFactory;

    protected $table = 'mouvement_stock';
    protected $primaryKey = 'id_mouvement_stock';
    public $timestamps = false;

    protected $fillable = [
        'type_mouvement_stock',
        'quantite',
        'date_mouv',
        'id_categorie',
        'id_produit',
    ];

    protected $dates = ['date_mouv'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
}
