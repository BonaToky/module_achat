<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  */
    public function index()
    {
        // $categories = Categorie::paginate(10);
        // return view('categories.index', compact('categories'));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     return view('categories.create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'libelle' => 'required|string|max:50|unique:categorie',
    //     ]);

    //     Categorie::create($request->all());

    //     return redirect()->route('categories.index')
    //         ->with('success', 'Catégorie créée avec succès!');
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show($id)
    // {
    //     $categorie = Categorie::with('produits')->findOrFail($id);
    //     return view('categories.show', compact('categorie'));
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit($id)
    // {
    //     $categorie = Categorie::findOrFail($id);
    //     return view('categories.edit', compact('categorie'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, $id)
    // {
    //     $categorie = Categorie::findOrFail($id);
        
    //     $request->validate([
    //         'libelle' => 'required|string|max:50|unique:categorie,libelle,' . $id . ',id_categorie',
    //     ]);

    //     $categorie->update($request->all());

    //     return redirect()->route('categories.index')
    //         ->with('success', 'Catégorie mise à jour avec succès!');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy($id)
    // {
    //     $categorie = Categorie::findOrFail($id);
        
    //     // Vérifier si la catégorie a des produits
    //     if ($categorie->produits()->count() > 0) {
    //         return redirect()->route('categories.index')
    //             ->with('error', 'Impossible de supprimer: cette catégorie contient des produits!');
    //     }
        
    //     $categorie->delete();

    //     return redirect()->route('categories.index')
    //         ->with('success', 'Catégorie supprimée avec succès!');
    // }
}