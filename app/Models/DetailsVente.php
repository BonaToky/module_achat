<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsVente extends Model
{
    use HasFactory;

    protected $table = 'details_vente';
    protected $primaryKey = 'id_details_vente';
    public $timestamps = false;

    protected $fillable = [
        'id_produit',
        'id_ticket',
        'quantite',
        'prix_unitaire',
        'total_ligne',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }
}
