@extends('layouts.app')

@section('title', 'Historique des Prix')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Historique des Prix</h1>
        <a href="{{ route('historique-prix.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouveau Prix
        </a>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Produit</label>
                    <select name="produit_id" class="form-select">
                        <option value="">Tous les produits</option>
                        @foreach($produits as $produit)
                            <option value="{{ $produit->id_produit }}" 
                                {{ request('produit_id') == $produit->id_produit ? 'selected' : '' }}>
                                {{ $produit->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-select">
                        <option value="">Tous</option>
                        <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="historique" {{ request('statut') == 'historique' ? 'selected' : '' }}>Historique</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
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
                            <th>Produit</th>
                            <th>Prix Achat</th>
                            <th>Prix Vente</th>
                            <th>Date Début</th>
                            <th>Date Fin</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historiques as $historique)
                            <tr>
                                <td>{{ $historique->id_historique }}</td>
                                <td>{{ $historique->produit->nom ?? 'N/A' }}</td>
                                <td>{{ number_format($historique->prix_achat, 2, ',', ' ') }} €</td>
                                <td>{{ number_format($historique->prix_vente, 2, ',', ' ') }} €</td>
                                <td>{{ $historique->date_debut->format('d/m/Y H:i') }}</td>
                                <td>{{ $historique->date_fin ? $historique->date_fin->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $historique->date_fin ? 'warning' : 'success' }}">
                                        {{ $historique->statut }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('historique-prix.show', $historique->id_historique) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('historique-prix.edit', $historique->id_historique) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('historique-prix.destroy', $historique->id_historique) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Supprimer cet historique?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Aucun historique de prix trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $historiques->links() }}
            </div>
        </div>
    </div>
</div>
@endsection