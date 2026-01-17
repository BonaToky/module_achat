<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role; // Assurez-vous d'avoir cette importation
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB; // Pour le débogage

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        $user = User::where('numero', $request->numero)->first();

        if ($user && Hash::check($request->password, $user->password_hash)) {
            Session::put('user_id', $user->id_users);
            return redirect('/mouvement_stock')
                ->with('success', 'Connexion réussie ! Bienvenue, ' . $user->nom);
        }

        return back()->withErrors(['numero' => 'Numéro ou mot de passe incorrect.']);
    }

    public function showRegisterForm()
    {
        // Récupérer les rôles depuis la base de données
        $roles = Role::orderBy('id_role')->get();
        
        // Si aucun rôle n'existe, en créer un par défaut
        if ($roles->isEmpty()) {
            // Créer le rôle Client par défaut
            Role::create([
                'libelle' => 'Client',
                'description' => 'Utilisateur standard'
            ]);
            
            // Recharger les rôles
            $roles = Role::orderBy('id_role')->get();
        }
        
        return view('login.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'numero' => 'required|string|max:50|unique:users',
            'adress' => 'nullable|string|max:100',
            'password' => 'required|string|min:6|confirmed',
            'id_role' => 'required|integer',
        ], [
            'numero.unique' => 'Ce numéro est déjà utilisé.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'id_role.required' => 'Veuillez sélectionner un rôle.',
        ]);

        try {
            // Vérifier si le rôle existe
            $roleExists = Role::where('id_role', $request->id_role)->exists();
            
            // Si le rôle n'existe pas, utiliser le premier rôle disponible
            if (!$roleExists) {
                $firstRole = Role::first();
                if (!$firstRole) {
                    // Créer un rôle par défaut si aucun n'existe
                    $firstRole = Role::create([
                        'libelle' => 'Client',
                        'description' => 'Utilisateur standard'
                    ]);
                }
                $roleId = $firstRole->id_role;
            } else {
                $roleId = $request->id_role;
            }

            User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'numero' => $request->numero,
                'password_hash' => Hash::make($request->password),
                'adress' => $request->adress,
                'solde' => 0,
                'id_role' => $roleId,
                'actif' => true,
            ]);

            return redirect()->route('login.form')
                ->with('success', 'Inscription réussie ! Connectez-vous maintenant.');
        } catch (\Exception $e) {
            // Pour le débogage, afficher l'erreur réelle
            \Log::error('Erreur inscription: ' . $e->getMessage());
            \Log::error('Trace: ' . $e->getTraceAsString());
            
            return back()->withInput()
                ->withErrors(['error' => 'Erreur lors de l\'inscription. Détails: ' . $e->getMessage()]);
        }
    }
}