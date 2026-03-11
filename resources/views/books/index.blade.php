@extends('layouts.app')
@section('content')
<a class="btn btn-primary mb-2" href="{{ route('books.create') }}">Ajouter livre</a>
<table class="table">@foreach($books as $book)<tr><td>{{ $book->title }}</td><td>{{ $book->stock_available }}/{{ $book->stock_total }}</td><td><a href="{{ route('books.edit',$book) }}">Edit</a></td></tr>@endforeach</table>
@endsection