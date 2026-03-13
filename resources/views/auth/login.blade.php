{{-- METAL-EXPLAIN: Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<h1 class="h4 mb-3">Connexion</h1>
<form method="post" action="{{ route('login.post') }}" class="card card-body">
    @csrf
    <input class="form-control mb-2" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
    <input class="form-control mb-3" type="password" name="password" placeholder="Mot de passe" required>
    <button class="btn btn-primary">Se connecter</button>
    <a class="btn btn-link mt-2" href="{{ route('register') }}">CrÃ©er un compte utilisateur</a>
</form>
@endsection

