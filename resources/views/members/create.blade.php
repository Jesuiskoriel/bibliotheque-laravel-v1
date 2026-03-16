{{-- Cette vue affiche l'interface.
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<form method="post" action="{{ route('members.store') }}">@csrf<input class="form-control mb-2" name="first_name" placeholder="Prénom"><input class="form-control mb-2" name="last_name" placeholder="Nom"><input class="form-control mb-2" name="email" placeholder="Email"><input class="form-control mb-2" name="phone" placeholder="Téléphone"><button class="btn btn-primary">Enregistrer</button></form>
@endsection
