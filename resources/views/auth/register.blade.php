{{-- Cette vue affiche l'interface.
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<div class="mx-auto" style="max-width: 480px;">
<p class="text-uppercase text-muted small mb-1">Créer un compte</p>
<h1 class="h3 mb-2">Inscription utilisateur</h1>
<p class="text-muted mb-4">Le compte créé sera automatiquement lié à une fiche adhérent pour emprunter des livres.</p>
<form method="post" action="{{ route('register.post') }}" class="card card-body">
    @csrf
    <input class="form-control mb-2" name="name" placeholder="Nom" value="{{ old('name') }}" required>
    <input class="form-control mb-2" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
    <input class="form-control mb-2" type="password" name="password" placeholder="Mot de passe" required>
    <input class="form-control mb-3" type="password" name="password_confirmation" placeholder="Confirmer mot de passe" required>
    <button class="btn btn-dark">Créer mon compte</button>
</form>
<div class="text-center mt-3">
    <span class="text-muted">Déjà inscrit ?</span>
    <a class="btn btn-link" href="{{ route('login') }}">Se connecter</a>
</div>
</div>
@endsection
