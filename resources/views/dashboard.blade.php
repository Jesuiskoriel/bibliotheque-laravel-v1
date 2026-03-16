{{-- Cette vue affiche l'interface.
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<h1 class="h3 mb-3">Tableau de bord gestionnaire</h1>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card card-soft"><div class="card-body"><div class="text-muted">Livres</div><div class="fs-3 fw-bold">{{ $stats['books'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card card-soft"><div class="card-body"><div class="text-muted">Utilisateurs</div><div class="fs-3 fw-bold">{{ $stats['users'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card card-soft"><div class="card-body"><div class="text-muted">Emprunts actifs</div><div class="fs-3 fw-bold">{{ $stats['active_loans'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card card-soft"><div class="card-body"><div class="text-muted">Retards</div><div class="fs-3 fw-bold text-danger">{{ $stats['overdue_loans'] }}</div></div></div></div>
</div>

<div class="card card-soft">
    <div class="card-header bg-white fw-semibold">Derniers emprunts</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Livre</th><th>Utilisateur</th><th>Date prêt</th><th>Retour prévu</th><th>Statut</th></tr></thead>
            <tbody>
            @forelse($recentLoans as $loan)
                <tr>
                    <td>{{ $loan->book->title }}</td>
                    <td>{{ $loan->user?->name ?? 'Utilisateur supprimé' }}</td>
                    <td>{{ $loan->loaned_at->format('d/m/Y') }}</td>
                    <td>{{ $loan->due_at->format('d/m/Y') }}</td>
                    <td>
                        @if($loan->returned_at)<span class="badge text-bg-success">Rendu</span>
                        @elseif($loan->isOverdue())<span class="badge text-bg-danger">En retard</span>
                        @else<span class="badge text-bg-warning">En cours</span>@endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucun emprunt</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
