<?php

namespace App\Http\Controllers;

use App\Models\HistoriquePrix;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriquePrixController extends Controller
{
    /**
     * Afficher la liste des historiques de prix
     */
    public function index(Request $request)
    {
        $query = HistoriquePrix::with('produit');
        
        // Filtre par produit
        if ($request->has('produit_id') && $request->produit_id) {
            $query->where('id_produit', $request->produit_id);
        }
        
        // Filtre par statut
        if ($request->has('statut') && $request->statut) {
            if ($request->statut == 'actif') {
                $query->whereNull('date_fin');
            } elseif ($request->statut == 'historique') {
                $query->whereNotNull('date_fin');
            }
        }
        
        $historiques = $query->orderBy('date_debut', 'desc')->paginate(15);
        $produits = Produit::orderBy('nom')->get();
        
        return view('historique-prix.index', compact('historiques', 'produits'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $produits = Produit::orderBy('nom')->get();
        return view('historique-prix.create', compact('produits'));
    }

    /**
     * Enregistrer un nouvel historique de prix
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_produit' => 'required|exists:produit,id_produit',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0|gte:prix_achat',
            'date_debut' => 'required|date',
        ]);

        DB::beginTransaction();
        
        try {
            // Clôturer l'ancien prix actif du même produit
            HistoriquePrix::where('id_produit', $request->id_produit)
                ->whereNull('date_fin')
                ->update(['date_fin' => now()]);
            
            // Créer le nouveau prix
            HistoriquePrix::create([
                'id_produit' => $request->id_produit,
                'prix_achat' => $request->prix_achat,
                'prix_vente' => $request->prix_vente,
                'date_debut' => $request->date_debut,
                'date_fin' => null, // Nouveau prix actif
            ]);

            DB::commit();

            return redirect()->route('historique-prix.index')
                ->with('success', 'Nouveau prix enregistré avec succès!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Afficher un historique de prix
     */
    public function show(HistoriquePrix $historiquePrix)
    {
        $historiquePrix->load('produit');
        return view('historique-prix.show', compact('historiquePrix'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(HistoriquePrix $historiquePrix)
    {
        $produits = Produit::orderBy('nom')->get();
        return view('historique-prix.edit', compact('historiquePrix', 'produits'));
    }

    /**
     * Mettre à jour un historique de prix
     */
    public function update(Request $request, HistoriquePrix $historiquePrix)
    {
        $request->validate([
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0|gte:prix_achat',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after:date_debut',
        ]);

        try {
            $historiquePrix->update([
                'prix_achat' => $request->prix_achat,
                'prix_vente' => $request->prix_vente,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
            ]);

            return redirect()->route('historique-prix.index')
                ->with('success', 'Historique de prix mis à jour avec succès!');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Supprimer un historique de prix
     */
    public function destroy(HistoriquePrix $historiquePrix)
    {
        try {
            // Vérifier si c'est le prix actif
            if (is_null($historiquePrix->date_fin)) {
                return redirect()->route('historique-prix.index')
                    ->with('error', 'Impossible de supprimer un prix actif. Clôturez-le d\'abord.');
            }
            
            $historiquePrix->delete();
            
            return redirect()->route('historique-prix.index')
                ->with('success', 'Historique de prix supprimé avec succès!');
                
        } catch (\Exception $e) {
            return redirect()->route('historique-prix.index')
                ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }
}