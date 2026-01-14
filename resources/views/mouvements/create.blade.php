@extends('layouts.app')

@section('title', 'Nouveau Mouvement')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
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
                    <select name="type_mouvement_stock" class="form-select" required>
                        <option value="">Sélectionnez un type</option>
                        @foreach($types as $key => $value)
                            <option value="{{ $key }}" {{ old('type_mouvement_stock') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Quantité *</label>
                    <input type="number" name="quantite" class="form-control" 
                           min="1" value="{{ old('quantite', 1) }}" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Produit *</label>
                    <select name="id_produit" class="form-select" required>
                        <option value="">Sélectionnez un produit</option>
                        @foreach($produits as $produit)
                            <option value="{{ $produit->id_produit }}" 
                                {{ old('id_produit') == $produit->id_produit ? 'selected' : '' }}>
                                {{ $produit->nom }} (Stock: {{ $produit->quantite_stock }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Catégorie *</label>
                    <select name="id_categorie" class="form-select" required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id_categorie }}" 
                                {{ old('id_categorie') == $categorie->id_categorie ? 'selected' : '' }}>
                                {{ $categorie->libelle }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Commentaire</label>
                <textarea name="commentaire" class="form-control" rows="3" 
                          placeholder="Raison du mouvement...">{{ old('commentaire') }}</textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Date du mouvement</label>
                <input type="datetime-local" name="date_mouv" class="form-control" 
                       value="{{ old('date_mouv', now()->format('Y-m-d\TH:i')) }}">
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="reset" class="btn btn-secondary me-md-2">Réinitialiser</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
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
</script>
@endsection