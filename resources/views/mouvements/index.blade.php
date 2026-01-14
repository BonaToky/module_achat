@extends('layouts.app')

@section('title', 'Mouvements de Stock')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Mouvements de Stock</h1>
    <a href="{{ route('mouvements.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nouveau Mouvement
    </a>
</div>

<!-- Filtre -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('mouvements.filter') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="">Tous les types</option>
                    <option value="ENTREE" {{ request('type') == 'ENTREE' ? 'selected' : '' }}>Entrée</option>
                    <option value="SORTIE" {{ request('type') == 'SORTIE' ? 'selected' : '' }}>Sortie</option>
                    <option value="RETOUR" {{ request('type') == 'RETOUR' ? 'selected' : '' }}>Retour</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Produit</label>
                <select name="produit_id" class="form-select">
                    <option value="">Tous les produits</option>
                    @foreach($produits ?? [] as $produit)
                        <option value="{{ $produit->id_produit }}" {{ request('produit_id') == $produit->id_produit ? 'selected' : '' }}>
                            {{ $produit->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date début</label>
                <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Date fin</label>
                <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary w-100">Filtrer</button>
            </div>
        </form>
    </div>
</div>

<!-- Tableau -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Produit</th>
                        <th>Catégorie</th>
                        <th>Quantité</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mouvements as $mouvement)
                        <tr>
                            <td>{{ $mouvement->id_mouvement_stock }}</td>
                            <td>{{ $mouvement->date_mouv->format('d/m/Y H:i') }}</td>
                            <td>
                                @if(str_contains($mouvement->type_mouvement_stock, 'ENTREE'))
                                    <span class="badge bg-success">{{ $mouvement->type_mouvement_stock }}</span>
                                @elseif(str_contains($mouvement->type_mouvement_stock, 'SORTIE'))
                                    <span class="badge bg-danger">{{ $mouvement->type_mouvement_stock }}</span>
                                @else
                                    <span class="badge bg-warning">{{ $mouvement->type_mouvement_stock }}</span>
                                @endif
                            </td>
                            <td>{{ $mouvement->produit->nom ?? 'N/A' }}</td>
                            <td>{{ $mouvement->categorie->libelle ?? 'N/A' }}</td>
                            <td>{{ $mouvement->quantite }}</td>
                            <td>
                                <a href="{{ route('mouvements.show', $mouvement->id_mouvement_stock) }}" 
                                   class="btn btn-sm btn-info" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('mouvements.destroy', $mouvement->id_mouvement_stock) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Supprimer ce mouvement?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucun mouvement trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $mouvements->links() }}
        </div>
    </div>
</div>
@endsection