@extends('layouts.app')
@section('content')
<a class="btn btn-primary mb-2" href="{{ route('authors.create') }}">Ajouter auteur</a>
<table class="table">@foreach($authors as $author)<tr><td>{{ $author->name }}</td><td><a href="{{ route('authors.edit',$author) }}">Edit</a></td></tr>@endforeach</table>
@endsection