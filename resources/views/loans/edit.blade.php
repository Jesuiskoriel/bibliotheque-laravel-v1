{{-- METAL-EXPLAIN: Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<form method="post" action="{{ route('loans.update',$loan) }}">@csrf @method('PUT')<select class="form-select mb-2" name="book_id">@foreach($books as $b)<option value="{{ $b->id }}" @selected($b->id==$loan->book_id)>{{ $b->title }}</option>@endforeach</select><select class="form-select mb-2" name="member_id">@foreach($members as $m)<option value="{{ $m->id }}" @selected($m->id==$loan->member_id)>{{ $m->full_name }}</option>@endforeach</select><input class="form-control mb-2" type="date" name="loaned_at" value="{{ $loan->loaned_at?->toDateString() }}"><input class="form-control mb-2" type="date" name="due_at" value="{{ $loan->due_at?->toDateString() }}"><input class="form-control mb-2" type="date" name="returned_at" value="{{ $loan->returned_at?->toDateString() }}"><textarea class="form-control mb-2" name="notes">{{ $loan->notes }}</textarea><button class="btn btn-primary">Save</button></form>
@endsection
