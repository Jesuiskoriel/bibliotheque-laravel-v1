{{-- METAL-EXPLAIN: Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<form method="post" action="{{ route('loans.store') }}">@csrf<select class="form-select mb-2" name="book_id">@foreach($books as $b)<option value="{{ $b->id }}">{{ $b->title }} ({{ $b->stock_available }} dispo)</option>@endforeach</select><select class="form-select mb-2" name="member_id">@foreach($members as $m)<option value="{{ $m->id }}">{{ $m->full_name }}</option>@endforeach</select><input class="form-control mb-2" type="date" name="loaned_at" value="{{ now()->toDateString() }}"><input class="form-control mb-2" type="date" name="due_at" value="{{ now()->addDays(14)->toDateString() }}"><textarea class="form-control mb-2" name="notes"></textarea><button class="btn btn-primary">Save</button></form>
@endsection
