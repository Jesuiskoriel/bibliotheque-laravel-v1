{{-- METAL-EXPLAIN: Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<form method="post" action="{{ route('books.store') }}">@csrf<input class="form-control mb-2" name="title" placeholder="Titre"><input class="form-control mb-2" name="isbn" placeholder="ISBN"><input class="form-control mb-2" type="number" name="published_year" placeholder="AnnÃ©e"><input class="form-control mb-2" type="number" name="stock_total" value="1"><select class="form-select mb-2" name="author_id">@foreach($authors as $a)<option value="{{ $a->id }}">{{ $a->name }}</option>@endforeach</select><select class="form-select mb-2" name="category_id">@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select><button class="btn btn-primary">Save</button></form>
@endsection
