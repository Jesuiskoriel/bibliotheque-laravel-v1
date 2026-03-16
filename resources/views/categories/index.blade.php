{{-- Cette vue affiche l'interface.
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<a class="btn btn-primary mb-2" href="{{ route('categories.create') }}">Ajouter catégorie</a>
<table class="table">@foreach($categories as $category)<tr><td>{{ $category->name }}</td><td><a href="{{ route('categories.edit',$category) }}">Modifier</a></td></tr>@endforeach</table>
@endsection
