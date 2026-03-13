{{-- METAL-EXPLAIN: Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<h1 class="h4 mb-3">Inscription utilisateur</h1>
<form method="post" action="{{ route('register.post') }}" class="card card-body">
    @csrf
    <input class="form-control mb-2" name="name" placeholder="Nom" value="{{ old('name') }}" required>
    <input class="form-control mb-2" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
    <input class="form-control mb-2" type="password" name="password" placeholder="Mot de passe" required>
    <input class="form-control mb-3" type="password" name="password_confirmation" placeholder="Confirmer mot de passe" required>
    <button class="btn btn-primary">CrÃ©er mon compte</button>
</form>
@endsection

