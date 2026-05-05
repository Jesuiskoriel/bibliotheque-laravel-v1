@extends('layouts.app')
@section('title', 'Connexion')
@section('content')

<div style="margin-bottom:32px;">
    <h1 style="font-family:'DM Serif Display',Georgia,serif;font-size:1.9rem;margin:0 0 6px;color:var(--text);">Bon retour.</h1>
    <p style="font-size:.9rem;color:var(--muted);margin:0;">Connectez-vous pour accéder à votre espace et gérer vos emprunts.</p>
</div>

<form method="post" action="{{ route('login.post') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label" for="email">Adresse e-mail</label>
        <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="vous@exemple.com" autocomplete="email" required>
    </div>
    <div class="mb-4">
        <label class="form-label" for="password">Mot de passe</label>
        <input class="form-control" id="password" name="password" type="password" placeholder="••••••••" autocomplete="current-password" required>
    </div>
    <button class="btn btn-dark w-100" type="submit">Se connecter</button>
</form>

<p style="text-align:center;margin-top:20px;font-size:.85rem;color:var(--muted);">
    Pas encore de compte ?
    <a href="{{ route('register') }}" style="color:var(--ink);font-weight:500;text-decoration:none;">Créer un compte</a>
</p>

<div style="margin-top:28px;padding:12px 14px;background:#F5F3EF;border-radius:9px;border:1px solid var(--border);">
    <p style="font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);font-weight:600;margin-bottom:6px;">Compte démo</p>
    <p style="font-size:.8rem;color:var(--muted);margin:0;font-family:'Inter',monospace;">user@biblio.local &nbsp;/&nbsp; password</p>
</div>

@endsection
