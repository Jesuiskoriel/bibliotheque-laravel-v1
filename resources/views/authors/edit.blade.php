{{-- METAL-EXPLAIN: Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<form method="post" action="{{ route('authors.update',$author) }}">@csrf @method('PUT')<input name="name" class="form-control mb-2" value="{{ $author->name }}"><textarea name="bio" class="form-control mb-2">{{ $author->bio }}</textarea><button class="btn btn-primary">Save</button></form>
@endsection
