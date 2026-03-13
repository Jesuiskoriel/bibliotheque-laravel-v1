{{-- METAL-EXPLAIN: Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'Ã©cran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<a class="btn btn-primary mb-2" href="{{ route('authors.Créer') }}">Ajouter auteur</a>
<table class="table">@foreach($authors as $author)<tr><td>{{ $author->name }}</td><td><a href="{{ route('authors.Modifier',$author) }}">Modifier</a></td></tr>@endforeach</table>
@endsection

