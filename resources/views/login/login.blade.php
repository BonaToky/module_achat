<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="text" name="numero" placeholder="Numéro" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>
