{{-- Cette vue affiche l'interface.
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<form method="post" action="{{ route('categories.update',$category) }}">@csrf @method('PUT')<input name="name" class="form-control mb-2" value="{{ $category->name }}"><textarea name="description" class="form-control mb-2">{{ $category->description }}</textarea><button class="btn btn-primary">Enregistrer</button></form>
@endsection
