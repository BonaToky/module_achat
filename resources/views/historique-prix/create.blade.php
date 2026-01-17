@extends('layouts.app')

@section('title', 'Nouveau Prix')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Nouveau Prix</h1>
        <a href="{{ route('historique-prix.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <!-- Messages d'alerte -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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

    <div class="card">
        <div class="card-body">
            <form action="{{ route('historique-prix.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Produit *</label>
                        <select name="id_produit" class="form-select @error('id_produit') is-invalid @enderror" required>
                            <option value="">Sélectionnez un produit</option>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id_produit }}" 
                                    {{ old('id_produit') == $produit->id_produit ? 'selected' : '' }}>
                                    {{ $produit->nom }}
                                    @if($produit->prix_actuel)
                                        (Prix actuel: {{ number_format($produit->prix_actuel, 2, ',', ' ') }} €)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('id_produit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date de début *</label>
                        <input type="datetime-local" name="date_debut" 
                               class="form-control @error('date_debut') is-invalid @enderror"
                               value="{{ old('date_debut', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('date_debut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prix d'achat (€) *</label>
                        <div class="input-group">
                            <input type="number" name="prix_achat" step="0.01" min="0"
                                   class="form-control @error('prix_achat') is-invalid @enderror"
                                   value="{{ old('prix_achat') }}" required>
                            <span class="input-group-text">€</span>
                            @error('prix_achat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prix de vente (€) *</label>
                        <div class="input-group">
                            <input type="number" name="prix_vente" step="0.01" min="0"
                                   class="form-control @error('prix_vente') is-invalid @enderror"
                                   value="{{ old('prix_vente') }}" required>
                            <span class="input-group-text">€</span>
                            @error('prix_vente')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Le prix de vente doit être supérieur ou égal au prix d'achat.</small>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Note :</strong> Lorsque vous créez un nouveau prix pour un produit, 
                    l'ancien prix actif sera automatiquement clôturé avec la date actuelle.
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
    // Calcul automatique de la marge
    document.addEventListener('DOMContentLoaded', function() {
        const prixAchatInput = document.querySelector('input[name="prix_achat"]');
        const prixVenteInput = document.querySelector('input[name="prix_vente"]');
        
        function calculerMarge() {
            const prixAchat = parseFloat(prixAchatInput.value) || 0;
            const prixVente = parseFloat(prixVenteInput.value) || 0;
            
            if (prixAchat > 0 && prixVente >= prixAchat) {
                const marge = prixVente - prixAchat;
                const margePourcentage = (marge / prixAchat * 100).toFixed(2);
                document.getElementById('info-marge').innerHTML = 
                    `Marge: ${marge.toFixed(2)} € (${margePourcentage}%)`;
            }
        }
        
        prixAchatInput.addEventListener('input', calculerMarge);
        prixVenteInput.addEventListener('input', calculerMarge);
        
        // Ajouter l'élément d'affichage de la marge
        const infoDiv = document.createElement('div');
        infoDiv.id = 'info-marge';
        infoDiv.className = 'mt-1 text-success fw-bold';
        prixVenteInput.parentNode.appendChild(infoDiv);
    });
</script>
@endsection
@endsection