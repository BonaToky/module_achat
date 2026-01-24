<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Ticket;
use App\Models\DetailsVente;
use App\Controllers\ProduitController;
use App\Models\MouvementStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VenteController extends Controller
{
    public function create()
    {
        $produits = Produit::with('categorie')->get();
        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['prix'] * $item['quantite'];
        }
        return view('ventes.create', compact('produits', 'cart', 'total'));
    }

    public function indexPanier()  // Changé de create() à index()
    {
        $produits = Produit::with('categorie')->get();
        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['prix'] * $item['quantite'];
        }
        return view('panier.index', compact('cart', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'id_produit' => 'required|exists:produit,id_produit',
            'quantite' => 'required|integer|min:1',
        ]);

        $produit = Produit::find($request->id_produit);
        $stock = $produit->stock_actuel;

        if ($request->quantite > $stock) {
            return back()->withErrors(['quantite' => 'Stock insuffisant.']);
        }

        $cart = Session::get('cart', []);
        $cart[$request->id_produit] = [
            'nom' => $produit->nom,
            'prix' => $produit->prix_actuel,
            'quantite' => $request->quantite,
        ];
        Session::put('cart', $cart);

        return back()->with('success', 'Produit ajouté au panier.');
    }

    public function removeFromCart($id_produit)
    {
        $cart = Session::get('cart', []);
        unset($cart[$id_produit]);
        Session::put('cart', $cart);
        return back();
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'id_client' => 'required|exists:users,id_users',
    //         'mode_paiement' => 'required|in:cash,mobile_money,carte',
    //     ]);

    //     $cart = Session::get('cart', []);
    //     if (empty($cart)) {
    //         return back()->withErrors(['cart' => 'Panier vide.']);
    //     }

    //     $ticketId = DB::transaction(function () use ($request, $cart) {
    //         $total = 0;
    //         foreach ($cart as $id_produit => $item) {
    //             $total += $item['prix'] * $item['quantite'];
    //         }

    //         $ticket = Ticket::create([
    //             'mode_paiement' => $request->mode_paiement,
    //             'total' => $total,
    //             'date_vente' => now(),
    //             'id_client' => $request->id_client,
    //         ]);

    //         foreach ($cart as $id_produit => $item) {
    //             DetailsVente::create([
    //                 'id_produit' => $id_produit,
    //                 'id_ticket' => $ticket->id_ticket,
    //                 'quantite' => $item['quantite'],
    //                 'prix_unitaire' => $item['prix'],
    //                 'total_ligne' => $item['prix'] * $item['quantite'],
    //             ]);

    //             // Mise à jour stock
    //             MouvementStock::create([
    //                 'type_mouvement_stock' => 'sortie',
    //                 'quantite' => $item['quantite'],
    //                 'date_mouv' => now(),
    //                 'id_categorie' => Produit::find($id_produit)->id_categorie,
    //                 'id_produit' => $id_produit,
    //             ]);
    //         }

    //         return $ticket->id_ticket;
    //     });

    //     Session::forget('cart');
    //     return redirect()->route('ventes.show', $ticketId);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'id_client' => 'required|exists:users,id_users',
            'mode_paiement' => 'required|in:cash,mobile_money,carte',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Panier vide.']);
        }

        $ticketId = DB::transaction(function () use ($request, $cart) {
            $total = 0;
            
            // Vérifier les stocks avant de procéder
            foreach ($cart as $id_produit => $item) {
                $produit = Produit::find($id_produit);
                
                // Vérifier si le produit existe
                if (!$produit) {
                    throw new \Exception("Le produit avec l'ID $id_produit n'existe pas.");
                }
                
                // Vérifier si la quantité en stock est suffisante
                // Supposons que votre colonne de stock est 'stock_actuel'
                if ($produit->stock_actuel < $item['quantite']) {
                    throw new \Exception("Stock insuffisant pour le produit: {$produit->nom}. Stock disponible: {$produit->stock_actuel}, Quantité demandée: {$item['quantite']}");
                }
                
                $total += $item['prix'] * $item['quantite'];
            }

            $ticket = Ticket::create([
                'mode_paiement' => $request->mode_paiement,
                'total' => $total,
                'date_vente' => now(),
                'id_client' => $request->id_client,
            ]);

            foreach ($cart as $id_produit => $item) {
                $produit = Produit::find($id_produit);
                $stockAvant = $produit->stock_actuel;
                
                // Calculer le nouveau stock
                $nouveauStock = $stockAvant - $item['quantite'];
                
                // Créer le détail de vente
                DetailsVente::create([
                    'id_produit' => $id_produit,
                    'id_ticket' => $ticket->id_ticket,
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $item['prix'],
                    'total_ligne' => $item['prix'] * $item['quantite'],
                ]);

                // Mise à jour du stock du produit en utilisant votre méthode
                $produit->updateStockActuel($nouveauStock);

                // Enregistrer le mouvement de stock
                MouvementStock::create([
                    'type_mouvement_stock' => 'sortie',
                    'quantite' => $item['quantite'],
                    'date_mouv' => now(),
                    'id_categorie' => $produit->id_categorie,
                    'id_produit' => $id_produit,
                    'stock_avant' => $stockAvant, // Stock avant l'opération
                    'stock_apres' => $nouveauStock, // Stock après l'opération
                    'id_ticket' => $ticket->id_ticket, // Optionnel: lier le mouvement au ticket
                ]);
            }

            return $ticket->id_ticket;
        });

        Session::forget('cart');
        return redirect()->route('ventes.show', $ticketId)
            ->with('success', 'Vente effectuée avec succès!');
    }

    public function show($id_ticket)
    {
        $ticket = Ticket::with('detailsVentes.produit', 'client')->findOrFail($id_ticket);
        return view('ventes.show', compact('ticket'));
    }
}
