<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';
    protected $primaryKey = 'id_ticket';
    public $timestamps = false;

    protected $fillable = [
        'mode_paiement',
        'total',
        'date_vente',
        'id_client',
    ];

    protected $dates = ['date_vente'];

    public function client()
    {
        return $this->belongsTo(User::class, 'id_client', 'id_users');
    }

    public function detailsVentes()
    {
        return $this->hasMany(DetailsVente::class, 'id_ticket');
    }

    public function livraison()
    {
        return $this->hasOne(Livraison::class, 'id_ticket');
    }
}
