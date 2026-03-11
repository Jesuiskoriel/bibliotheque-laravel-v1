@extends('layouts.app')
@section('content')
<a class="btn btn-primary mb-2" href="{{ route('loans.create') }}">Nouvel emprunt</a>
<table class="table">@foreach($loans as $loan)<tr><td>{{ $loan->book->title }}</td><td>{{ $loan->member->full_name }}</td><td>{{ $loan->due_at->format('d/m/Y') }}</td><td>{{ $loan->returned_at?->format('d/m/Y') ?? '-' }}</td><td><a href="{{ route('loans.edit',$loan) }}">Edit</a></td></tr>@endforeach</table>
@endsection