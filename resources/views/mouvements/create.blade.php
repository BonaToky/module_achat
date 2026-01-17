@extends('layouts.app')

@section('title', 'Nouveau Mouvement')

@section('content')
<div class="container">
    <!-- Messages d'alerte -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Afficher les erreurs de validation -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Veuillez corriger les erreurs suivantes :</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <h1 class="h3">Nouveau Mouvement de Stock</h1>
        <a href="{{ route('mouvements.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('mouvements.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type de mouvement *</label>
                        <select name="type_mouvement_stock" class="form-select @error('type_mouvement_stock') is-invalid @enderror" required>
                            <option value="">Sélectionnez un type</option>
                            @foreach($types as $key => $value)
                                <option value="{{ $key }}" {{ old('type_mouvement_stock') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('type_mouvement_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantité *</label>
                        <input type="number" name="quantite" class="form-control @error('quantite') is-invalid @enderror" 
                               min="1" value="{{ old('quantite', 1) }}" required>
                        @error('quantite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Produit *</label>
                        <select name="id_produit" class="form-select @error('id_produit') is-invalid @enderror" required>
                            <option value="">Sélectionnez un produit</option>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id_produit }}" 
                                    {{ old('id_produit') == $produit->id_produit ? 'selected' : '' }}>
                                    {{ $produit->nom }} (Stock: {{ $produit->stock_actuel }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_produit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Catégorie *</label>
                        <select name="id_categorie" class="form-select @error('id_categorie') is-invalid @enderror" required>
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id_categorie }}" 
                                    {{ old('id_categorie') == $categorie->id_categorie ? 'selected' : '' }}>
                                    {{ $categorie->libelle }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_categorie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Date du mouvement</label>
                    <input type="datetime-local" name="date_mouv" class="form-control @error('date_mouv') is-invalid @enderror" 
                           value="{{ old('date_mouv', now()->format('Y-m-d\TH:i')) }}">
                    @error('date_mouv')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-secondary me-md-2">Réinitialiser</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Mettre à jour les catégories quand on change de produit
    document.querySelector('select[name="id_produit"]').addEventListener('change', function() {
        const produitId = this.value;
        const produits = @json($produits);
        const produit = produits.find(p => p.id_produit == produitId);
        
        if (produit) {
            document.querySelector('select[name="id_categorie"]').value = produit.id_categorie;
        }
    });

    // Fermer automatiquement les alertes après 5 secondes
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endsection