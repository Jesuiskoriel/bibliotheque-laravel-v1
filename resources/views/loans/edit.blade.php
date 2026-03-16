{{-- Cette vue affiche l'interface.
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<h1 class="h4 mb-3">Modifier un emprunt</h1>
<form method="post" action="{{ route('loans.update',$loan) }}" class="card card-soft card-body">
    @csrf
    @method('PUT')
    <select class="form-select mb-2" name="book_id">@foreach($books as $b)<option value="{{ $b->id }}" @selected($b->id==$loan->book_id)>{{ $b->title }}</option>@endforeach</select>
    <select class="form-select mb-2" name="user_id">@foreach($users as $u)<option value="{{ $u->id }}" @selected($u->id==$loan->user_id)>{{ $u->name }} ({{ $u->email }})</option>@endforeach</select>
    <input class="form-control mb-2" type="date" name="loaned_at" value="{{ $loan->loaned_at?->toDateString() }}">
    <input class="form-control mb-2" type="date" name="due_at" value="{{ $loan->due_at?->toDateString() }}">
    <input class="form-control mb-2" type="date" name="returned_at" value="{{ $loan->returned_at?->toDateString() }}">
    <textarea class="form-control mb-3" name="notes">{{ $loan->notes }}</textarea>
    <button class="btn btn-primary">Enregistrer</button>
</form>
@endsection
