<?php
namespace App\Http\Controllers;

use App\Models\MouvementStock;
use App\Models\Produit;
use App\Models\Categorie;
use App\Controllers\ProduitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MouvementStockController extends Controller
{

    public function index()
    {
        $produits = Produit::orderBy('nom')->get(); // ← Ajoutez cette ligne
        $mouvements = MouvementStock::with(['produit', 'categorie'])
            ->orderBy('date_mouv', 'desc')
            ->paginate(15);
        
        return view('mouvements.index', compact('mouvements', 'produits')); // ← Ajoutez $produits
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produits = Produit::orderBy('nom')->get();
        $categories = Categorie::orderBy('libelle')->get();
        $types = [
            'ENTREE' => 'Entree',
            'SORTIE' => 'Sortie',
        ];
        
        return view('mouvements.create', compact('produits', 'categories', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'type_mouvement_stock' => 'required|string|max:50',
    //         'quantite' => 'required|integer|min:1',
    //         'id_produit' => 'required|exists:produit,id_produit',
    //         'id_categorie' => 'required|exists:categorie,id_categorie',
    //         'commentaire' => 'nullable|string|max:255',
    //         'date_mouv' => 'nullable|date',
    //     ]);

    //     DB::beginTransaction();
        
    //     try {
    //         $produit = Produit::findOrFail($request->id_produit);
            
    //         // Convertir le type en minuscules pour correspondre à l'ENUM
    //         $type = strtolower($request->type_mouvement_stock);
            
    //         // Vérifier si c'est une valeur valide pour l'ENUM
    //         if (!in_array($type, ['entree', 'sortie'])) {
    //             return back()->withInput()
    //                 ->with('error', 'Type de mouvement invalide. Utilisez "ENTREE" ou "SORTIE".');
    //         }
            
    //         // Vérifier le stock pour les sorties
    //         if ($type == 'sortie') {
    //             $stockActuel = $produit->stock_actuel;
                
    //             if ($request->quantite > $stockActuel) {
    //                 return back()->withInput()
    //                     ->with('error', 'Stock insuffisant! Stock disponible: ' . $stockActuel);
    //             }
    //         }
            
    //         // Créer le mouvement avec le type en minuscules
    //         MouvementStock::create([
    //             'type_mouvement_stock' => $type, // 'entree' ou 'sortie' en minuscules
    //             'quantite' => $type == 'sortie' 
    //                 ? -$request->quantite // Négatif pour les sorties
    //                 : $request->quantite,  // Positif pour les entrées
    //             'id_produit' => $request->id_produit,
    //             'id_categorie' => $request->id_categorie,
    //             'date_mouv' => $request->date_mouv ?? now(),
    //         ]);

    //         DB::commit();

    //         return redirect()->route('mouvements.index')
    //             ->with('success', 'Mouvement enregistré avec succès!');
                    
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->withInput()
    //             ->with('error', 'Erreur: ' . $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        $request->validate([
            'type_mouvement_stock' => 'required|string|max:50',
            'quantite' => 'required|integer|min:1',
            'id_produit' => 'required|exists:produit,id_produit',
            'id_categorie' => 'required|exists:categorie,id_categorie',
            'commentaire' => 'nullable|string|max:255',
            'date_mouv' => 'nullable|date',
        ]);

        DB::beginTransaction();
        
        try {
            $produit = Produit::findOrFail($request->id_produit);
            
            // Convertir le type en minuscules
            $type = strtolower($request->type_mouvement_stock);
            
            // Vérifier si c'est une valeur valide
            if (!in_array($type, ['entree', 'sortie'])) {
                return back()->withInput()
                    ->with('error', 'Type de mouvement invalide. Utilisez "ENTREE" ou "SORTIE".');
            }
            
            // Stock avant modification
            $stockAvant = $produit->stock_actuel;
            
            // Vérifier le stock pour les sorties
            if ($type == 'sortie') {
                if ($request->quantite > $stockAvant) {
                    return back()->withInput()
                        ->with('error', 'Stock insuffisant! Stock disponible: ' . $stockAvant);
                }
            }
            
            // Calculer le nouveau stock
            if ($type == 'entree') {
                $nouveauStock = $stockAvant + $request->quantite;
            } else { // sortie
                $nouveauStock = $stockAvant - $request->quantite;
            }
            
            // Mettre à jour le stock actuel du produit
            $produit->updateStockActuel($nouveauStock);
            
            // Créer le mouvement de stock
            MouvementStock::create([
                'type_mouvement_stock' => $type,
                'quantite' => $request->quantite, // Toujours positif
                'id_produit' => $request->id_produit,
                'id_categorie' => $request->id_categorie,
                'commentaire' => $request->commentaire,
                'date_mouv' => $request->date_mouv ?? now(),
                'stock_avant' => $stockAvant,     // Stock avant mouvement
                'stock_apres' => $nouveauStock,   // Stock après mouvement
                // Optionnel: ajouter qui a fait le mouvement
                // 'user_id' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('mouvements.index')
                ->with('success', 'Mouvement enregistré et stock mis à jour avec succès! Stock actuel: ' . $nouveauStock);
                    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mouvement = MouvementStock::with(['produit', 'categorie'])
            ->findOrFail($id);
        
        return view('mouvements.show', compact('mouvement'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mouvement = MouvementStock::findOrFail($id);
        $mouvement->delete();
        
        return redirect()->route('mouvements.index')
            ->with('success', 'Mouvement supprimé avec succès!');
    }

    /**
     * Filtre des mouvements
     */
    public function filter(Request $request)
    {
        $query = MouvementStock::with(['produit', 'categorie']);
        
        if ($request->type) {
            $query->where('type_mouvement_stock', 'like', '%' . $request->type . '%');
        }
        
        if ($request->produit_id) {
            $query->where('id_produit', $request->produit_id);
        }
        
        if ($request->date_debut) {
            $query->whereDate('date_mouv', '>=', $request->date_debut);
        }
        
        if ($request->date_fin) {
            $query->whereDate('date_mouv', '<=', $request->date_fin);
        }
        
        $mouvements = $query->orderBy('date_mouv', 'desc')->paginate(15);
        $produits = Produit::all();
        
        return view('mouvements.index', compact('mouvements', 'produits'));
    }
}
