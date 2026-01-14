<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
</head>
<body>
    <h1>Liste des Produits</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Catégorie</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produits as $produit)
            <tr>
                <td>{{ $produit->nom }}</td>
                <td>{{ $produit->prix_actuel }}</td>
                <td>{{ $produit->stock_actuel }}</td>
                <td>{{ $produit->categorie->libelle }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('ventes.create') }}">Faire une vente</a>
</body>
</html>
