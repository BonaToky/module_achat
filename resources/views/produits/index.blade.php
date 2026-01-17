<<<<<<< Updated upstream
=======
<<<<<<< Updated upstream
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
</head>
<body>
    <h1>Liste des Produits</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Catégorie</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produits as $produit)
            <tr>
                <td>{{ $produit->nom }}</td>
                <td>{{ $produit->prix_actuel }}</td>
                <td>{{ $produit->stock_actuel }}</td>
                <td>{{ $produit->categorie->libelle }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('ventes.create') }}">Faire une vente</a>
</body>
</html>
=======
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
=======
                            <th width="80">Image</th> <!-- Colonne ajoutée -->
>>>>>>> Stashed changes
                            <th>Nom</th>
                            <th class="text-end">Prix</th>
                            <th class="text-center">Quantité</th>
                            <th>Catégorie</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produits as $produit)
                            <tr>
<<<<<<< Updated upstream
=======
                                <!-- Cellule image -->
                                <td>
                                    @if($produit->image)
                                        <img src="{{ asset('storage/' . $produit->image) }}" 
                                             alt="{{ $produit->nom }}"
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;"
                                             onerror="this.src='https://placehold.co/60x60?text=No+Image'">
                                    @else
                                        <div style="width: 60px; height: 60px; background: #e9ecef; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
                                <td colspan="4" class="text-center text-muted">
=======
                                <td colspan="5" class="text-center text-muted"> <!-- Changé à 5 colonnes -->
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
=======
>>>>>>> Stashed changes
>>>>>>> Stashed changes
