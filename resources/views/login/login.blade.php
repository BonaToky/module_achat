<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div style="max-width: 400px; margin: 100px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2 style="text-align: center; margin-bottom: 30px;">Connexion</h2>
        
        {{-- Formulaire de connexion --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div style="margin-bottom: 15px;">
                <input type="text" name="numero" placeholder="Numéro de téléphone" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <input type="password" name="password" placeholder="Mot de passe" required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <button type="submit" 
                    style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Se connecter
            </button>
        </form>
        
        {{-- Lien d'inscription --}}
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('register.form') }}">Créer un compte
                Créer un compte
            </a>
        </div>
    </div>
</body>
</html>