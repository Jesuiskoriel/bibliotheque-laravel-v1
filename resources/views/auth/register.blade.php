@extends('layouts.app')
@section('title', 'Créer un compte')
@section('content')

<div style="margin-bottom:32px;">
    <h1 style="font-family:'DM Serif Display',Georgia,serif;font-size:1.9rem;margin:0 0 6px;color:var(--text);">Créer un compte.</h1>
    <p style="font-size:.9rem;color:var(--muted);margin:0;">Le compte créé sera automatiquement associé à une fiche adhérent.</p>
</div>

<form method="post" action="{{ route('register.post') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label" for="name">Nom complet</label>
        <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Jean Dupont" autocomplete="name" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="email">Adresse e-mail</label>
        <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="vous@exemple.com" autocomplete="email" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="password">Mot de passe</label>
        <input class="form-control" id="password" name="password" type="password" placeholder="••••••••" autocomplete="new-password" required>
    </div>
    <div class="mb-4">
        <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="••••••••" autocomplete="new-password" required>
    </div>
    <button class="btn btn-dark w-100" type="submit">Créer mon compte</button>
</form>

<p style="text-align:center;margin-top:20px;font-size:.85rem;color:var(--muted);">
    Déjà inscrit ?
    <a href="{{ route('login') }}" style="color:var(--ink);font-weight:500;text-decoration:none;">Se connecter</a>
</p>

@endsection
