{{-- METAL-EXPLAIN: Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<form method="post" action="{{ route('books.update',$book) }}">@csrf @method('PUT')<input class="form-control mb-2" name="title" value="{{ $book->title }}"><input class="form-control mb-2" name="isbn" value="{{ $book->isbn }}"><input class="form-control mb-2" type="number" name="published_year" value="{{ $book->published_year }}"><input class="form-control mb-2" type="number" name="stock_total" value="{{ $book->stock_total }}"><select class="form-select mb-2" name="author_id">@foreach($authors as $a)<option value="{{ $a->id }}" @selected($a->id==$book->author_id)>{{ $a->name }}</option>@endforeach</select><select class="form-select mb-2" name="category_id">@foreach($categories as $c)<option value="{{ $c->id }}" @selected($c->id==$book->category_id)>{{ $c->name }}</option>@endforeach</select><button class="btn btn-primary">Save</button></form>
@endsection
