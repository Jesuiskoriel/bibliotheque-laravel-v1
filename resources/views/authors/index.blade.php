{{-- Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'Ã©cran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<a class="btn btn-primary mb-2" href="{{ route('authors.create') }}">Ajouter auteur</a>
<table class="table">@foreach($authors as $author)<tr><td>{{ $author->name }}</td><td><a href="{{ route('authors.edit',$author) }}">Modifier</a></td></tr>@endforeach</table>
@endsection
