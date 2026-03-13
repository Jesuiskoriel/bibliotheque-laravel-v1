{{-- Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'Ã©cran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<form method="post" action="{{ route('authors.store') }}">@csrf<input name="name" class="form-control mb-2" placeholder="Nom"><textarea name="bio" class="form-control mb-2"></textarea><button class="btn btn-primary">Enregistrer</button></form>
@endsection

