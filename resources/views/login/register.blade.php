<!-- filepath: resources/views/login/register.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { background: #fff; padding: 20px 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 320px; }
        h2 { text-align: center; margin-bottom: 20px; }
        input, select { width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        .error { color: red; font-size: 14px; margin-bottom: 10px; }
        .success { color: green; font-size: 14px; margin-bottom: 10px; }
        a { display: block; text-align: center; margin-top: 10px; color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .debug-info { background: #f8f9fa; padding: 10px; border-radius: 4px; font-size: 12px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>

        <!-- Affichage des erreurs de validation -->
        @if ($errors->any())
            <div class="error">
                <strong>Erreurs :</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Affichage des messages -->
        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <!-- Informations personnelles -->
            <input type="text" name="nom" placeholder="Nom" value="{{ old('nom') }}" required>
            
            <input type="text" name="prenom" placeholder="Prénom" value="{{ old('prenom') }}" required>
            
            <input type="text" name="numero" placeholder="Numéro de téléphone" value="{{ old('numero') }}" required>
            
            <input type="text" name="adress" placeholder="Adresse (optionnel)" value="{{ old('adress') }}">
            
            <!-- Mot de passe -->
            <input type="password" name="password" placeholder="Mot de passe (min. 6 caractères)" required>
            
            <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
            
            <!-- Sélection du rôle -->
            <label for="id_role">Rôle :</label>
            <select name="id_role" id="id_role" required>
                <option value="">Sélectionnez un rôle</option>
                @if(isset($roles) && $roles->count() > 0)
                    @foreach($roles as $role)
                        <option value="{{ $role->id_role }}" 
                            {{ old('id_role') == $role->id_role ? 'selected' : '' }}>
                            {{ $role->libelle }}
                        </option>
                    @endforeach
                @else
                    <!-- Message si aucun rôle n'est disponible -->
                    <option value="">Aucun rôle disponible</option>
                @endif
            </select>
            
            <button type="submit">S'inscrire</button>
        </form>

        <a href="{{ route('login.form') }}">Déjà un compte ? Connectez-vous</a>
        
        <!-- Section de débogage (à retirer en production) -->
        @if(app()->environment('local'))
        <div class="debug-info">
            <strong>Debug :</strong><br>
            Rôles disponibles : {{ isset($roles) ? $roles->count() : 0 }}<br>
            @if(isset($roles))
                @foreach($roles as $role)
                    ID: {{ $role->id_role }} - {{ $role->libelle }}<br>
                @endforeach
            @endif
        </div>
        @endif
    </div>
</body>
</html>