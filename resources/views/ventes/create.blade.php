<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection des Produits</title>
</head>
<body>
    <h1>Sélection des Produits à Vendre</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h2>Produits Disponibles</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Catégorie</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produits as $produit)
            <tr>
                <td>{{ $produit->nom }}</td>
                <td>{{ $produit->prix_actuel }}</td>
                <td>{{ $produit->stock_actuel }}</td>
                <td>{{ $produit->categorie->libelle }}</td>
                <td>
                    <form action="{{ route('ventes.addToCart') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_produit" value="{{ $produit->id_produit }}">
                        <input type="number" name="quantite" min="1" max="{{ $produit->stock_actuel }}" required>
                        <button type="submit">Ajouter au Panier</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Panier</h2>
    @if(empty($cart))
        <p>Panier vide.</p>
    @else
        <table border="1">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $id => $item)
                <tr>
                    <td>{{ $item['nom'] }}</td>
                    <td>{{ $item['prix'] }}</td>
                    <td>{{ $item['quantite'] }}</td>
                    <td>{{ $item['prix'] * $item['quantite'] }}</td>
                    <td>
                        <form action="{{ route('ventes.removeFromCart', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Retirer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p><strong>Total: {{ $total }}</strong></p>

        <form action="{{ route('ventes.store') }}" method="POST">
            @csrf
            <label for="id_client">ID Client:</label>
            <input type="number" name="id_client" required>
            <label for="mode_paiement">Mode de Paiement:</label>
            <select name="mode_paiement" required>
                <option value="cash">Cash</option>
                <option value="mobile_money">Mobile Money</option>
                <option value="carte">Carte</option>
            </select>
            <button type="submit">Confirmer la Vente</button>
        </form>
    @endif

    <a href="{{ route('produits.index') }}">Retour aux Produits</a>
</body>
</html>
