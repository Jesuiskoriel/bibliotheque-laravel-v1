{{-- METAL-EXPLAIN: Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'Ã©cran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<a class="btn btn-primary mb-2" href="{{ route('books.Créer') }}">Ajouter livre</a>
<table class="table">@foreach($books as $book)<tr><td>{{ $book->title }}</td><td>{{ $book->stock_available }}/{{ $book->stock_total }}</td><td><a href="{{ route('books.Modifier',$book) }}">Modifier</a></td></tr>@endforeach</table>
@endsection

