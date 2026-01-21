@extends('layouts.app')

@section('title', 'Ajouter un produit')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Ajouter un nouveau produit</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du produit *</label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" name="nom" value="{{ old('nom') }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image du produit</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Formats acceptés: JPEG, PNG, JPG, GIF, WEBP. Taille max: 2MB
                            </div>
                            
                            <!-- Prévisualisation de l'image -->
                            <div class="mt-2" id="imagePreview" style="display: none;">
                                <img id="previewImage" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_categorie" class="form-label">Catégorie *</label>
                            <select class="form-select @error('id_categorie') is-invalid @enderror" 
                                    id="id_categorie" name="id_categorie" required>
                                <option value="">Sélectionnez une catégorie</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id_categorie }}" 
                                            {{ old('id_categorie') == $categorie->id_categorie ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_categorie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stock_actuel" class="form-label">Stock initial</label>
                            <input type="number" class="form-control @error('stock_actuel') is-invalid @enderror" 
                                   id="stock_actuel" name="stock_actuel" value="{{ old('stock_actuel', 0) }}" min="0">
                            @error('stock_actuel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('produits.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    .img-thumbnail {
        border: 2px dashed #dee2e6;
        padding: 5px;
        background-color: #f8f9fa;
    }
</style>
@endsection