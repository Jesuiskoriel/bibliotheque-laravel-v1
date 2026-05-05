@extends('layouts.app')
@section('title', 'Tableau de bord')
@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <p class="text-uppercase mb-1" style="font-size:.65rem;letter-spacing:.1em;color:var(--muted);font-weight:600;">Admin</p>
        <h1 style="font-family:'DM Serif Display',Georgia,serif;font-size:1.6rem;margin:0;color:var(--text);">Tableau de bord</h1>
    </div>
    <a class="btn btn-sm btn-dark" href="{{ route('loans.create') }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:5px;"><path d="M12 5v14M5 12h14"/></svg>
        Nouvel emprunt
    </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card" style="border-left: 3px solid var(--ink); padding: 18px 20px;">
            <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.09em;color:var(--muted);font-weight:600;">Livres</div>
            <div style="font-family:'DM Serif Display',Georgia,serif;font-size:2.2rem;line-height:1.1;margin:6px 0 2px;color:var(--text);">{{ $stats['books'] }}</div>
            <div style="font-size:.75rem;color:var(--muted);">dans le catalogue</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card" style="border-left: 3px solid var(--amber); padding: 18px 20px;">
            <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.09em;color:var(--muted);font-weight:600;">Utilisateurs</div>
            <div style="font-family:'DM Serif Display',Georgia,serif;font-size:2.2rem;line-height:1.1;margin:6px 0 2px;color:var(--text);">{{ $stats['users'] }}</div>
            <div style="font-size:.75rem;color:var(--muted);">membres inscrits</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card" style="border-left: 3px solid #15803D; padding: 18px 20px;">
            <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.09em;color:var(--muted);font-weight:600;">Emprunts actifs</div>
            <div style="font-family:'DM Serif Display',Georgia,serif;font-size:2.2rem;line-height:1.1;margin:6px 0 2px;color:var(--text);">{{ $stats['active_loans'] }}</div>
            <div style="font-size:.75rem;color:var(--muted);">livres en circulation</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card" style="border-left: 3px solid #B91C1C; padding: 18px 20px;">
            <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.09em;color:var(--muted);font-weight:600;">Retards</div>
            <div style="font-family:'DM Serif Display',Georgia,serif;font-size:2.2rem;line-height:1.1;margin:6px 0 2px;color:{{ $stats['overdue_loans'] > 0 ? '#B91C1C' : 'var(--text)' }};">{{ $stats['overdue_loans'] }}</div>
            <div style="font-size:.75rem;color:var(--muted);">retours en retard</div>
        </div>
    </div>
</div>

{{-- Recent loans table --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span>Derniers emprunts</span>
        <a href="{{ route('loans.index') }}" style="font-size:.78rem;color:var(--amber);text-decoration:none;font-weight:500;">Voir tous</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Utilisateur</th>
                    <th>Date prêt</th>
                    <th>Retour prévu</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
            @forelse($recentLoans as $loan)
                <tr>
                    <td>
                        <span style="font-weight:500;">{{ $loan->book->title }}</span>
                    </td>
                    <td style="color:var(--muted);">{{ $loan->user?->name ?? 'Utilisateur supprimé' }}</td>
                    <td style="color:var(--muted);white-space:nowrap;">{{ $loan->loaned_at->format('d/m/Y') }}</td>
                    <td style="color:var(--muted);white-space:nowrap;">{{ $loan->due_at->format('d/m/Y') }}</td>
                    <td>
                        @if($loan->returned_at)
                            <span class="badge text-bg-success">Rendu</span>
                        @elseif($loan->isOverdue())
                            <span class="badge text-bg-danger">En retard</span>
                        @else
                            <span class="badge text-bg-warning">En cours</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:32px;color:var(--muted);font-size:.875rem;">
                        Aucun emprunt enregistré.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
