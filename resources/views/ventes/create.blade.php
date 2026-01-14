@extends('layouts.app')
@section('title', 'Créer une Vente')

@section('content')
<div class="container">

    <h1 class="h3 mb-4">Sélection des Produits à Vendre</h1>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Produits --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            Produits Disponibles
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Catégorie</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produits as $produit)
                    <tr>
                        <td>{{ $produit->nom }}</td>
                        <td>{{ number_format($produit->prix_actuel, 0, ',', ' ') }} Ar</td>
                        <td>{{ $produit->stock_actuel }}</td>
                        <td>{{ $produit->categorie->libelle }}</td>
                        <td>
                            <form action="{{ route('ventes.addToCart') }}" method="POST"
                                  class="d-flex gap-2 justify-content-center">
                                @csrf
                                <input type="hidden" name="id_produit" value="{{ $produit->id_produit }}">
                                <input type="number"
                                       name="quantite"
                                       class="form-control form-control-sm w-50"
                                       min="1"
                                       max="{{ $produit->stock_actuel }}"
                                       required>
                                <button type="submit" class="btn btn-success btn-sm">
                                    Ajouter
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Panier --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Panier
        </div>

        <div class="card-body">
            @if(empty($cart))
                <p class="text-muted">Panier vide.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Prix</th>
                                <th>Quantité</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $id => $item)
                            <tr>
                                <td>{{ $item['nom'] }}</td>
                                <td>{{ number_format($item['prix'], 0, ',', ' ') }} Ar</td>
                                <td>{{ $item['quantite'] }}</td>
                                <td>{{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }} Ar</td>
                                <td>
                                    <form action="{{ route('ventes.removeFromCart', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            Retirer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <p class="fw-bold text-end">
                    Total : {{ number_format($total, 0, ',', ' ') }} Ar
                </p>

                {{-- Formulaire vente --}}
                <form action="{{ route('ventes.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-md-4">
                        <label class="form-label">ID Client</label>
                        <input type="number" name="id_client" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Mode de Paiement</label>
                        <select name="mode_paiement" class="form-select" required>
                            <option value="cash">Cash</option>
                            <option value="mobile_money">Mobile Money</option>
                            <option value="carte">Carte</option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            Confirmer la Vente
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <a href="{{ route('produits.index') }}" class="btn btn-secondary mt-3">
        ← Retour aux Produits
    </a>

</div>
@endsection
