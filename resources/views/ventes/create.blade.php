@extends('layouts.app')
@section('title', 'Créer une Vente')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-3 mb-md-0">Sélection des Produits</h1>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-primary fs-6 px-3 py-2">
                {{ $produits->count() }} produit{{ $produits->count() > 1 ? 's' : '' }}
            </span>
            <!-- Tu pourras ajouter un compteur panier ici plus tard -->
        </div>
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

    {{-- Grille de produits style marketplace --}}
    @if($produits->isNotEmpty())
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3 g-md-4">
            @foreach($produits as $produit)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm product-card transition-all hover-shadow-lg">
                        <!-- Image -->
                        <div class="position-relative overflow-hidden bg-light" style="height: 220px;">
                            @if($produit->image)
                                <img src="{{ asset('storage/' . $produit->image) }}"
                                     class="card-img-top w-100 h-100 object-fit-contain p-3"
                                     alt="{{ $produit->nom }}"
                                     loading="lazy">
                            @else
                                <img src="{{ asset('images/no-image.jpg') }}"
                                     class="card-img-top w-100 h-100 object-fit-contain p-4 opacity-75"
                                     alt="Pas d'image"
                                     loading="lazy">
                            @endif

                            <!-- Badge stock en haut à droite -->
                            <div class="position-absolute top-0 end-0 m-3">
                                @if($produit->stock_actuel > 0)
                                    <span class="badge bg-success px-2 py-1 fs-6">
                                        {{ $produit->stock_actuel }}
                                    </span>
                                @else
                                    <span class="badge bg-danger px-2 py-1 fs-6">Rupture</span>
                                @endif
                            </div>
                        </div>

                        <!-- Contenu -->
                        <div class="card-body d-flex flex-column p-3">
                            <h5 class="card-title mb-2 fw-semibold fs-6 text-dark line-clamp-2" style="min-height: 2.8em;">
                                {{ $produit->nom }}
                            </h5>

                            <div class="mt-auto">
                                <p class="text-primary fw-bold fs-5 mb-2">
                                    {{ number_format($produit->prix_actuel, 0, ',', ' ') }} Ar
                                </p>

                                <small class="text-muted d-block mb-3">
                                    {{ $produit->categorie->libelle ?? 'Sans catégorie' }}
                                </small>

                                <!-- Formulaire ajout panier -->
                                <form action="{{ route('ventes.addToCart') }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="hidden" name="id_produit" value="{{ $produit->id_produit }}">

                                    <input type="number"
                                           name="quantite"
                                           class="form-control text-center"
                                           style="max-width: 80px;"
                                           min="1"
                                           max="{{ $produit->stock_actuel }}"
                                           value="1"
                                           required
                                           {{ $produit->stock_actuel == 0 ? 'disabled' : '' }}>

                                    <button type="submit"
                                            class="btn btn-success flex-grow-1"
                                            {{ $produit->stock_actuel == 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-cart-plus me-1"></i>Ajouter
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5 my-5">
            <i class="bi bi-cart-x display-1 text-secondary d-block mb-4"></i>
            <h4 class="text-muted">Aucun produit disponible pour le moment</h4>
            <p class="text-muted">Revenez plus tard ou contactez l'administrateur.</p>
        </div>
    @endif

</div>

<style>
    .product-card {
        transition: all 0.25s ease;
        border-radius: 12px;
        overflow: hidden;
        background: white;
    }
    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.12) !important;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection