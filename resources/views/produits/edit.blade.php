@extends('layouts.app')

@section('title', 'Modifier le produit')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Modifier le produit: {{ $produit->nom }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('produits.update', $produit->id_produit) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du produit *</label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" name="nom" value="{{ old('nom', $produit->nom) }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image du produit</label>
                            
                            <!-- Image actuelle -->
                            @if($produit->image)
                                <div class="mb-2">
                                    <img src="{{ asset($produit->image) }}" alt="{{ $produit->nom }}" 
                                         class="img-thumbnail" style="max-height: 150px;">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" 
                                               name="delete_image" id="delete_image" value="1">
                                        <label class="form-check-label text-danger" for="delete_image">
                                            <i class="fas fa-trash"></i> Supprimer cette image
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted d-block mb-2">Image actuelle</small>
                            @endif
                            
                            <!-- Nouvelle image -->
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Formats acceptés: JPEG, PNG, JPG, GIF, WEBP. Taille max: 2MB
                            </div>
                            
                            <!-- Prévisualisation de la nouvelle image -->
                            <div class="mt-2" id="imagePreview" style="display: none;">
                                <small class="text-muted">Nouvelle image:</small><br>
                                <img id="previewImage" class="img-thumbnail mt-1" style="max-height: 150px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_categorie" class="form-label">Catégorie *</label>
                            <select class="form-select @error('id_categorie') is-invalid @enderror" 
                                    id="id_categorie" name="id_categorie" required>
                                <option value="">Sélectionnez une catégorie</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id_categorie }}" 
                                            {{ (old('id_categorie', $produit->id_categorie) == $categorie->id_categorie) ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_categorie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stock_actuel" class="form-label">Stock actuel</label>
                            <input type="number" class="form-control @error('stock_actuel') is-invalid @enderror" 
                                   id="stock_actuel" name="stock_actuel" 
                                   value="{{ old('stock_actuel', $produit->stock_actuel) }}" min="0">
                            @error('stock_actuel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Stock calculé à partir des mouvements: <strong>{{ $produit->stock_calcule ?? 0 }}</strong>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-text">
                                        <strong>Créé le:</strong> {{ $produit->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-text">
                                        <strong>Dernière modification:</strong> {{ $produit->updated_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('produits.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary me-md-2">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                            <button type="button" class="btn btn-danger" 
                                    onclick="confirmDelete({{ $produit->id_produit }})">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/produits/${id}`;
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        
        form.appendChild(csrf);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    
    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            
            reader.readAsDataURL(this.files[0]);
        } else {
            imagePreview.style.display = 'none';
        }
    });
});
</script>
@endsection

@section('styles')
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }
    .btn-primary {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #3a9bed 0%, #00d9e1 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
    }
    .btn-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
    }
    .btn-danger:hover {
        background: linear-gradient(135deg, #e082ea 0%, #e4465b 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 87, 108, 0.4);
    }
    .img-thumbnail {
        border: 2px dashed #dee2e6;
        padding: 5px;
        background-color: #f8f9fa;
    }
</style>
@endsection