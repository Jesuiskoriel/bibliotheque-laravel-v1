{{-- Cette vue affiche l'interface.
Version simple : ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')

@section('content')
<div class="mx-auto" style="max-width: 420px;">
<p class="text-uppercase text-muted small mb-1">Bibliothèque</p>
<h1 class="h3 mb-2">Connexion</h1>
<p class="text-muted mb-4">Connectez-vous pour consulter le catalogue et gérer vos emprunts.</p>

<form method="post" action="{{ route('login.post') }}" class="card card-body">
@csrf
<input class="form-control mb-2" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
<input class="form-control mb-3" type="password" name="password" placeholder="Mot de passe" required>
<button class="btn btn-dark">Se connecter</button>
<div class="text-center mt-3">
<span class="text-muted">Pas encore de compte ?</span>
<a class="btn btn-link" href="{{ route('register') }}">Créer un compte</a>
</div>
</form>
<div class="text-muted small mt-3">Compte démo utilisateur : `user@biblio.local` / `password`</div>
</div>
@endsection
