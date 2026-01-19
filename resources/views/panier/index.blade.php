@extends('layouts.app')
@section('title', 'Panier - Créer une Vente')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-3 mb-md-0">Votre Panier</h1>
        <span class="badge bg-primary fs-6 px-3 py-2">
            {{ count($cart ?? []) }} article{{ count($cart ?? []) > 1 ? 's' : '' }}
        </span>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(empty($cart))
        <div class="card shadow-sm text-center py-5 my-5">
            <i class="bi bi-cart-x display-1 text-secondary mb-4"></i>
            <h4 class="text-muted">Votre panier est vide</h4>
            <p class="text-muted mb-4">Ajoutez des produits pour continuer.</p>
            <a href="{{ route('produits.index') }}" class="btn btn-primary btn-lg px-5">
                ← Voir les produits
            </a>
        </div>
    @else
        <div class="row">
            <!-- Colonne gauche : Liste des articles -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Articles dans le panier</h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($cart as $id => $item)
                            <div class="p-3 border-bottom hover-bg-light transition-all">
                                <div class="row align-items-center g-3">
                                    <!-- Image -->
                                    <div class="col-3 col-md-2">
                                        @if($item['image'] ?? false)
                                            <img src="{{ asset('storage/' . $item['image']) }}"
                                                 alt="{{ $item['nom'] }}"
                                                 class="img-fluid rounded shadow-sm"
                                                 style="max-height: 100px; object-fit: contain;">
                                        @else
                                            <img src="{{ asset('images/no-image.jpg') }}"
                                                 alt="Pas d'image"
                                                 class="img-fluid rounded bg-light opacity-75"
                                                 style="max-height: 100px; object-fit: contain;">
                                        @endif
                                    </div>

                                    <!-- Infos -->
                                    <div class="col-6 col-md-7">
                                        <h6 class="mb-1 fw-semibold">{{ $item['nom'] }}</h6>
                                        <p class="text-primary fw-bold mb-1">
                                            {{ number_format($item['prix'], 0, ',', ' ') }} Ar
                                        </p>
                                        <small class="text-muted">Quantité : {{ $item['quantite'] }}</small>
                                    </div>

                                    <!-- Total + Action -->
                                    <div class="col-3 col-md-3 text-end">
                                        <p class="fw-bold mb-2">
                                            {{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }} Ar
                                        </p>
                                        <form action="{{ route('ventes.removeFromCart', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Retirer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Colonne droite : Résumé + Formulaire -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Récapitulatif</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Sous-total ({{ count($cart) }} article{{ count($cart) > 1 ? 's' : '' }})</span>
                            <span class="fw-bold">{{ number_format($total, 0, ',', ' ') }} Ar</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fs-5 fw-bold">Total</span>
                            <span class="fs-4 fw-bold text-primary">
                                {{ number_format($total, 0, ',', ' ') }} Ar
                            </span>
                        </div>

                        <!-- Formulaire de confirmation -->
                        <form action="{{ route('ventes.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-medium">ID Client</label>
                                <input type="number" name="id_client" class="form-control" required placeholder="Entrez l'ID du client">
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Mode de Paiement</label>
                                <select name="mode_paiement" class="form-select" required>
                                    <option value="" disabled selected>Choisir un mode...</option>
                                    <option value="cash">Cash</option>
                                    <option value="mobile_money">Mobile Money</option>
                                    <option value="carte">Carte</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="bi bi-check-circle me-2"></i> Confirmer la Vente
                            </button>
                        </form>

                        <div class="mt-4 text-center">
                            <a href="{{ route('produits.index') }}" class="text-muted small">
                                ← Continuer les achats
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

<style>
    .hover-bg-light:hover {
        background-color: #f8f9fa;
    }
    .transition-all {
        transition: background-color 0.2s ease;
    }
</style>
@endsection