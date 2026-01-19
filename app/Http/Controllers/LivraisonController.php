<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use Illuminate\Http\Request;

class LivraisonController extends Controller
{
    public function index()
    {
        $livraisons = Livraison::all();
        return view('livraisons.index', compact('livraisons'));
    }

    public function create()
    {
        return view('livraisons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ticket' => 'required|integer',
            'adresse_livraison' => 'required|string|max:255',
            'statut_livraison' => 'nullable|string|max:50',
            'date_livraison_prevue' => 'nullable|date',
            'date_livraison_reelle' => 'nullable|date',
            'livreur_id' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        Livraison::create($request->all());

        return redirect()->route('livraisons.index')->with('success', 'Livraison créée avec succès.');
    }

    public function show(Livraison $livraison)
    {
        return view('livraisons.show', compact('livraison'));
    }

    public function edit(Livraison $livraison)
    {
        return view('livraisons.edit', compact('livraison'));
    }

    public function update(Request $request, Livraison $livraison)
    {
        $request->validate([
            'id_ticket' => 'required|integer',
            'adresse_livraison' => 'required|string|max:255',
            'statut_livraison' => 'nullable|string|max:50',
            'date_livraison_prevue' => 'nullable|date',
            'date_livraison_reelle' => 'nullable|date',
            'livreur_id' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $livraison->update($request->all());

        return redirect()->route('livraisons.index')->with('success', 'Livraison mise à jour.');
    }

    public function destroy(Livraison $livraison)
    {
        $livraison->delete();
        return redirect()->route('livraisons.index')->with('success', 'Livraison supprimée.');
    }
}
