@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails Livraison #{{ $livraison->id_livraison }}</h1>
    <p><strong>Ticket :</strong> {{ $livraison->id_ticket }}</p>
    <p><strong>Adresse :</strong> {{ $livraison->adresse_livraison }}</p>
    <p><strong>Statut :</strong> {{ $livraison->statut_livraison }}</p>
    <p><strong>Date prévue :</strong> {{ $livraison->date_livraison_prevue }}</p>
    <p><strong>Date réelle :</strong> {{ $livraison->date_livraison_reelle }}</p>
    <p><strong>Livreur :</strong> {{ $livraison->livreur_id }}</p>
    <p><strong>Notes :</strong> {{ $livraison->notes }}</p>

    <a href="{{ route('livraisons.index') }}" class="btn btn-secondary">Retour</a>
    <a href="{{ route('livraisons.edit', $livraison->id_livraison) }}" class="btn btn-warning">Éditer</a>
</div>
@endsection
