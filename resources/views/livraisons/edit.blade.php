@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Éditer la Livraison #{{ $livraison->id_livraison }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('livraisons.update', $livraison->id_livraison) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Ticket</label>
            <input type="number" name="id_ticket" class="form-control" value="{{ $livraison->id_ticket }}" required>
        </div>
        <div class="mb-3">
            <label>Adresse de livraison</label>
            <input type="text" name="adresse_livraison" class="form-control" value="{{ $livraison->adresse_livraison }}" required>
        </div>
        <div class="mb-3">
            <label>Statut</label>
            <input type="text" name="statut_livraison" class="form-control" value="{{ $livraison->statut_livraison }}">
        </div>
        <div class="mb-3">
            <label>Date prévue</label>
            <input type="date" name="date_livraison_prevue" class="form-control" value="{{ $livraison->date_livraison_prevue }}">
        </div>
        <div class="mb-3">
            <label>Date réelle</label>
            <input type="datetime-local" name="date_livraison_reelle" class="form-control" value="{{ $livraison->date_livraison_reelle ? date('Y-m-d\TH:i', strtotime($livraison->date_livraison_reelle)) : '' }}">
        </div>
        <div class="mb-3">
            <label>Livreur (ID)</label>
            <input type="number" name="livreur_id" class="form-control" value="{{ $livraison->livreur_id }}">
        </div>
        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control">{{ $livraison->notes }}</textarea>
        </div>
        <button class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('livraisons.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
