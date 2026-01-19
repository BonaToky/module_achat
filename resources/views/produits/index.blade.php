@extends('layouts.app')

@section('title', 'Liste des Produits')

@section('content')
<div class="container-fluid">

    <!-- Titre + action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Liste des Produits</h1>

        <a href="{{ route('ventes.create') }}" class="btn btn-success">
            <i class="bi bi-cart-plus"></i> Faire une vente
        </a>
    </div>

    <!-- Tableau -->
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th class="text-end">Prix</th>
                            <th class="text-center">Quantité</th>
                            <th>Catégorie</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produits as $produit)
                            <tr>
                                <td class="fw-semibold">{{ $produit->nom }}</td>
                                <td class="text-end">
                                    {{ number_format($produit->prix_actuel, 2, ',', ' ') }} Ar
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">
                                        {{ $produit->stock_actuel }}
                                    </span>
                                </td>
                                <td>{{ $produit->categorie->libelle ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Aucun produit disponible
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
