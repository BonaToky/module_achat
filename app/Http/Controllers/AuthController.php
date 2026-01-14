<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
            // Stocker l'utilisateur en session
            Session::put('user_id', $user->id_users);
            return redirect('/mouvement_stock')
                ->with('success', 'Connexion réussie ! Bienvenue, ' . $user->nom);
        }

        return "Numéro ou mot de passe incorrect.";
    }
}
