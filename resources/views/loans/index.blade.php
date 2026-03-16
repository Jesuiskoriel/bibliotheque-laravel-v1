{{-- Cette vue affiche l'interface.
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<a class="btn btn-primary mb-2" href="{{ route('loans.create') }}">Nouvel emprunt</a>
<div class="card card-soft">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead><tr><th>Livre</th><th>Utilisateur</th><th>Retour prévu</th><th>Retour effectif</th><th class="text-end">Action</th></tr></thead>
            <tbody>@foreach($loans as $loan)<tr><td>{{ $loan->book->title }}</td><td>{{ $loan->user?->name ?? 'Utilisateur supprimé' }}</td><td>{{ $loan->due_at->format('d/m/Y') }}</td><td>{{ $loan->returned_at?->format('d/m/Y') ?? '-' }}</td><td class="text-end"><a href="{{ route('loans.edit',$loan) }}">Modifier</a></td></tr>@endforeach</tbody>
        </table>
    </div>
</div>
@endsection
