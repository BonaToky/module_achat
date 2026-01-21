<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::with('categorie')->get();
        return view('produits.index', compact('produits'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('produits.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'id_categorie' => 'required|exists:categorie,id_categorie',
            'stock_actuel' => 'nullable|integer|min:0',
        ]);

        try {
            // Gestion de l'upload d'image
            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request->file('image'));
                $validated['image'] = $imagePath;
            } else {
                $validated['image'] = null;
            }

            Produit::create($validated);
            
            return redirect()->route('produits.index')
                ->with('success', 'Produit créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création du produit: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        $categories = Categorie::all();
        return view('produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'id_categorie' => 'required|exists:categorie,id_categorie',
            'stock_actuel' => 'nullable|integer|min:0',
        ]);

        try {
            // Gestion de l'upload d'image
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image si elle existe
                $this->deleteImage($produit->image);
                
                // Uploader la nouvelle image
                $imagePath = $this->uploadImage($request->file('image'));
                $validated['image'] = $imagePath;
            } elseif ($request->has('delete_image') && $request->delete_image == '1') {
                // Supprimer l'image si l'utilisateur a coché la case
                $this->deleteImage($produit->image);
                $validated['image'] = null;
            } else {
                // Garder l'image existante
                $validated['image'] = $produit->image;
            }

            $produit->update($validated);
            
            return redirect()->route('produits.index')
                ->with('success', 'Produit modifié avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la modification du produit: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $produit = Produit::findOrFail($id);
            
            // Supprimer l'image associée
            $this->deleteImage($produit->image);
            
            $produit->delete();
            
            return redirect()->route('produits.index')
                ->with('success', 'Produit supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('produits.index')
                ->with('error', 'Erreur lors de la suppression du produit: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $produit = Produit::with(['categorie', 'historiquePrix', 'mouvementStocks'])
            ->findOrFail($id);
        return view('produits.show', compact('produit'));
    }

    /**
     * Méthode pour uploader une image
     */
    private function uploadImage($imageFile)
    {
        // Chemin du dossier de stockage
        $storagePath = 'public/uploads/produits';
        $publicPath = 'storage/uploads/produits';
        
        // Créer les dossiers s'ils n'existent pas
        if (!File::exists(storage_path('app/' . $storagePath))) {
            File::makeDirectory(storage_path('app/' . $storagePath), 0755, true);
        }
        
        if (!File::exists(public_path($publicPath))) {
            File::makeDirectory(public_path($publicPath), 0755, true);
        }
        
        // Générer un nom unique pour l'image
        $fileName = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
        
        // Stocker l'image
        $imageFile->storeAs($storagePath, $fileName);
        
        // Retourner le chemin public
        return $publicPath . '/' . $fileName;
    }

    /**
     * Méthode pour supprimer une image
     */
    private function deleteImage($imagePath)
    {
        if ($imagePath && File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
            
            // Essayer aussi de supprimer du storage
            $storagePath = str_replace('storage/', 'app/public/', $imagePath);
            if (File::exists(storage_path($storagePath))) {
                File::delete(storage_path($storagePath));
            }
        }
    }

    /**
     * Méthode pour récupérer l'URL complète de l'image
     */
    public static function getImageUrl($imagePath)
    {
        if (!$imagePath) {
            return asset('images/default-product.png');
        }
        
        if (File::exists(public_path($imagePath))) {
            return asset($imagePath);
        }
        
        return asset('images/default-product.png');
    }
}