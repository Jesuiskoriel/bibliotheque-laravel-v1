@extends('layouts.app')
@section('content')
<a class="btn btn-primary mb-2" href="{{ route('categories.create') }}">Ajouter catégorie</a>
<table class="table">@foreach($categories as $category)<tr><td>{{ $category->name }}</td><td><a href="{{ route('categories.edit',$category) }}">Edit</a></td></tr>@endforeach</table>
@endsection