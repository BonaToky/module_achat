@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Livraisons</h1>
    <a href="{{ route('livraisons.create') }}" class="btn btn-primary mb-3">Nouvelle Livraison</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ticket</th>
                <th>Adresse</th>
                <th>Statut</th>
                <th>Date prévue</th>
                <th>Date réelle</th>
                <th>Livreur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($livraisons as $livraison)
                <tr>
                    <td>{{ $livraison->id_livraison }}</td>
                    <td>{{ $livraison->id_ticket }}</td>
                    <td>{{ $livraison->adresse_livraison }}</td>
                    <td>{{ $livraison->statut_livraison }}</td>
                    <td>{{ $livraison->date_livraison_prevue }}</td>
                    <td>{{ $livraison->date_livraison_reelle }}</td>
                    <td>{{ $livraison->livreur_id }}</td>
                    <td>
                        <a href="{{ route('livraisons.show', $livraison->id_livraison) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('livraisons.edit', $livraison->id_livraison) }}" class="btn btn-warning btn-sm">Éditer</a>
                        <form action="{{ route('livraisons.destroy', $livraison->id_livraison) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette livraison ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
