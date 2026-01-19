@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer une Livraison</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('livraisons.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Ticket</label>
            <input type="number" name="id_ticket" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Adresse de livraison</label>
            <input type="text" name="adresse_livraison" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Statut</label>
            <input type="text" name="statut_livraison" class="form-control" value="en_attente">
        </div>
        <div class="mb-3">
            <label>Date prévue</label>
            <input type="date" name="date_livraison_prevue" class="form-control">
        </div>
        <div class="mb-3">
            <label>Date réelle</label>
            <input type="datetime-local" name="date_livraison_reelle" class="form-control">
        </div>
        <div class="mb-3">
            <label>Livreur (ID)</label>
            <input type="number" name="livreur_id" class="form-control">
        </div>
        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>
        <button class="btn btn-success">Créer</button>
        <a href="{{ route('livraisons.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
