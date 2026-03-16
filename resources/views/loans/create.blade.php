{{-- Cette vue affiche l'interface.
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<h1 class="h4 mb-3">Nouvel emprunt</h1>
<form method="post" action="{{ route('loans.store') }}" class="card card-soft card-body">
    @csrf
    <select class="form-select mb-2" name="book_id">@foreach($books as $b)<option value="{{ $b->id }}">{{ $b->title }} ({{ $b->stock_available }} dispo)</option>@endforeach</select>
    <select class="form-select mb-2" name="user_id">@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>@endforeach</select>
    <input class="form-control mb-2" type="date" name="loaned_at" value="{{ now()->toDateString() }}">
    <input class="form-control mb-2" type="date" name="due_at" value="{{ now()->addDays(14)->toDateString() }}">
    <textarea class="form-control mb-3" name="notes" placeholder="Notes internes"></textarea>
    <button class="btn btn-primary">Enregistrer</button>
</form>
@endsection
