<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index()
    // {
    //     $produits = Produit::with('categorie')->paginate(10);
    //     return view('produits.index', compact('produits'));
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     $categories = Categorie::all();
    //     return view('produits.create', compact('categories'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nom' => 'required|string|max:100',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //         'id_categorie' => 'required|exists:categorie,id_categorie',
    //         'description' => 'nullable|string',
    //         'prix' => 'required|numeric|min:0',
    //         'quantite_stock' => 'required|integer|min:0',
    //     ]);

    //     $data = $request->all();
        
    //     if ($request->hasFile('image')) {
    //         $imageName = time() . '.' . $request->image->extension();
    //         $request->image->move(public_path('images/produits'), $imageName);
    //         $data['image'] = 'images/produits/' . $imageName;
    //     }

    //     Produit::create($data);

    //     return redirect()->route('produits.index')
    //         ->with('success', 'Produit créé avec succès!');
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show($id)
    // {
    //     $produit = Produit::with(['categorie', 'mouvements'])->findOrFail($id);
    //     return view('produits.show', compact('produit'));
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit($id)
    // {
    //     $produit = Produit::findOrFail($id);
    //     $categories = Categorie::all();
    //     return view('produits.edit', compact('produit', 'categories'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, $id)
    // {
    //     $produit = Produit::findOrFail($id);
        
    //     $request->validate([
    //         'nom' => 'required|string|max:100',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //         'id_categorie' => 'required|exists:categorie,id_categorie',
    //         'description' => 'nullable|string',
    //         'prix' => 'required|numeric|min:0',
    //     ]);

    //     $data = $request->all();
        
    //     if ($request->hasFile('image')) {
    //         // Supprimer l'ancienne image si elle existe
    //         if ($produit->image && file_exists(public_path($produit->image))) {
    //             unlink(public_path($produit->image));
    //         }
            
    //         $imageName = time() . '.' . $request->image->extension();
    //         $request->image->move(public_path('images/produits'), $imageName);
    //         $data['image'] = 'images/produits/' . $imageName;
    //     } else {
    //         $data['image'] = $produit->image;
    //     }

    //     $produit->update($data);

    //     return redirect()->route('produits.index')
    //         ->with('success', 'Produit mis à jour avec succès!');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy($id)
    // {
    //     $produit = Produit::findOrFail($id);
        
    //     // Supprimer l'image si elle existe
    //     if ($produit->image && file_exists(public_path($produit->image))) {
    //         unlink(public_path($produit->image));
    //     }
        
    //     $produit->delete();

    //     return redirect()->route('produits.index')
    //         ->with('success', 'Produit supprimé avec succès!');
    // }
}