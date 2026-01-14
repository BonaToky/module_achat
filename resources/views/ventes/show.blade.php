<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Vente</title>
</head>
<body>
    <h1>Ticket de Vente #{{ $ticket->id_ticket }}</h1>
    <p><strong>Client:</strong> {{ $ticket->client->nom }} {{ $ticket->client->prenom }}</p>
    <p><strong>Date:</strong> {{ $ticket->date_vente }}</p>
    <p><strong>Mode de Paiement:</strong> {{ $ticket->mode_paiement }}</p>

    <h2>Détails</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ticket->detailsVentes as $detail)
            <tr>
                <td>{{ $detail->produit->nom }}</td>
                <td>{{ $detail->quantite }}</td>
                <td>{{ $detail->prix_unitaire }}</td>
                <td>{{ $detail->quantite * $detail->prix_unitaire }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Total: {{ $ticket->total }}</strong></p>

    <a href="{{ route('produits.index') }}">Retour aux Produits</a>
</body>
</html>
