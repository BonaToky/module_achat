@extends('layouts.app')

@section('title', 'Détail Mouvement')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Détail du Mouvement</h1>
    <div>
        <a href="{{ route('mouvements.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="30%">ID Mouvement</th>
                <td>{{ $mouvement->id_mouvement_stock }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>
                    @if(str_contains($mouvement->type_mouvement_stock, 'ENTREE'))
                        <span class="badge bg-success">{{ $mouvement->type_mouvement_stock }}</span>
                    @elseif(str_contains($mouvement->type_mouvement_stock, 'SORTIE'))
                        <span class="badge bg-danger">{{ $mouvement->type_mouvement_stock }}</span>
                    @else
                        <span class="badge bg-warning">{{ $mouvement->type_mouvement_stock }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ $mouvement->date_mouv->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Produit</th>
                <td>
                    {{ $mouvement->produit->nom ?? 'N/A' }}
                    @if($mouvement->produit)
                        <br><small class="text-muted">Stock actuel: {{ $mouvement->produit->quantite_stock }}</small>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Catégorie</th>
                <td>{{ $mouvement->categorie->libelle ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Quantité</th>
                <td>{{ $mouvement->quantite }}</td>
            </tr>
            @if(str_contains($mouvement->type_mouvement_stock, '-'))
                <tr>
                    <th>Commentaire</th>
                    <td>{{ explode('-', $mouvement->type_mouvement_stock, 2)[1] }}</td>
                </tr>
            @endif
        </table>
    </div>
</div>
@endsection