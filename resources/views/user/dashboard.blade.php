@extends('layouts.app')
@section('title', 'Mon espace')
@section('content')

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
        <p class="text-uppercase mb-1" style="font-size:.65rem;letter-spacing:.1em;color:var(--muted);font-weight:600;">Espace utilisateur</p>
        <h1 style="font-family:'DM Serif Display',Georgia,serif;font-size:1.6rem;margin:0;color:var(--text);">Bonjour, {{ auth()->user()->name }}</h1>
    </div>
    <form method="get" action="{{ route('user.dashboard') }}" class="d-flex gap-2" style="max-width:340px;width:100%;">
        <input class="form-control form-control-sm" type="search" name="q" value="{{ request('q') }}" placeholder="Titre, auteur, catégorie…" style="flex:1;">
        <button class="btn btn-sm btn-dark" type="submit">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        </button>
    </form>
</div>

@if($errors->has('borrow'))
    <div class="bib-alert bib-alert-danger" style="display:flex;align-items:center;gap:9px;padding:10px 14px;border-radius:9px;background:#FEE2E2;color:#B91C1C;border-left:3px solid #B91C1C;margin-bottom:16px;font-size:.875rem;">
        {{ $errors->first('borrow') }}
    </div>
@endif

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card" style="padding:16px 18px;border-left:3px solid var(--ink);">
            <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.09em;color:var(--muted);font-weight:600;">Catalogue</div>
            <div style="font-family:'DM Serif Display',Georgia,serif;font-size:1.9rem;line-height:1.1;margin:5px 0 2px;">{{ $books->total() }}</div>
            <div style="font-size:.73rem;color:var(--muted);">livres disponibles</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card" style="padding:16px 18px;border-left:3px solid var(--amber);">
            <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.09em;color:var(--muted);font-weight:600;">Historique</div>
            <div style="font-family:'DM Serif Display',Georgia,serif;font-size:1.9rem;line-height:1.1;margin:5px 0 2px;">{{ $myTotalBorrowed }}</div>
            <div style="font-size:.73rem;color:var(--muted);">livres empruntés</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card" style="padding:16px 18px;border-left:3px solid #15803D;">
            <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.09em;color:var(--muted);font-weight:600;">En cours</div>
            <div style="font-family:'DM Serif Display',Georgia,serif;font-size:1.9rem;line-height:1.1;margin:5px 0 2px;">{{ $myActiveLoans->count() }}</div>
            <div style="font-size:.73rem;color:var(--muted);">emprunts actifs</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card" style="padding:16px 18px;border-left:3px solid #64748B;">
            <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.09em;color:var(--muted);font-weight:600;">Rendus</div>
            <div style="font-family:'DM Serif Display',Georgia,serif;font-size:1.9rem;line-height:1.1;margin:5px 0 2px;">{{ $myReturnedLoans }}</div>
            <div style="font-size:.73rem;color:var(--muted);">emprunts terminés</div>
        </div>
    </div>
</div>

{{-- Catalogue --}}
<div class="card mb-4">
    <div class="card-header">Catalogue</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Auteur</th>
                    <th>Catégorie</th>
                    <th>Disponibilité</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($books as $book)
                <tr>
                    <td>
                        <div style="font-weight:500;">{{ $book->title }}</div>
                        <div style="font-size:.75rem;color:var(--muted);">ISBN {{ $book->isbn }}</div>
                    </td>
                    <td style="color:var(--muted);">{{ $book->author->name }}</td>
                    <td>
                        <span style="font-size:.75rem;background:#F1F5F9;color:#475569;padding:2px 9px;border-radius:20px;font-weight:500;">{{ $book->category->name }}</span>
                    </td>
                    <td>
                        @if($book->is_available)
                            <span class="badge text-bg-success">{{ $book->stock_available }}/{{ $book->stock_total }}</span>
                        @else
                            <span class="badge text-bg-secondary">Indisponible</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        @php $alreadyBorrowed = $myActiveLoans->contains('book_id', $book->id); @endphp
                        @if($alreadyBorrowed)
                            <span class="badge text-bg-warning" style="padding:5px 10px;">Déjà emprunté</span>
                        @elseif($book->is_available)
                            <form method="post" action="{{ route('user.loans.store') }}">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button class="btn btn-sm btn-dark" type="submit" style="cursor:pointer;">Emprunter</button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-outline-secondary" disabled>Non disponible</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:32px;color:var(--muted);font-size:.875rem;">Aucun livre trouvé.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($books->hasPages())
        <div style="padding:14px 18px;border-top:1px solid var(--border);">{{ $books->links() }}</div>
    @endif
</div>

<div class="row g-4">
    {{-- Active loans --}}
    <div class="col-xl-7">
        <div class="card h-100">
            <div class="card-header">Mes emprunts en cours</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr><th>Livre</th><th>Retour prévu</th><th>Statut</th><th style="text-align:right;">Action</th></tr>
                    </thead>
                    <tbody>
                    @forelse($myActiveLoans as $loan)
                        <tr>
                            <td style="font-weight:500;">{{ $loan->book->title }}</td>
                            <td style="color:var(--muted);white-space:nowrap;">{{ $loan->due_at->format('d/m/Y') }}</td>
                            <td>
                                @if($loan->isOverdue())
                                    <span class="badge text-bg-danger">En retard</span>
                                @else
                                    <span class="badge text-bg-warning">En cours</span>
                                @endif
                            </td>
                            <td style="text-align:right;">
                                <form method="post" action="{{ route('user.loans.return', $loan) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-outline-success" type="submit" style="cursor:pointer;">Rendre</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center;padding:28px;color:var(--muted);font-size:.875rem;">Aucun emprunt actif.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-5 d-flex flex-column gap-4">
        {{-- History --}}
        <div class="card">
            <div class="card-header">Historique personnel</div>
            <div class="list-group list-group-flush" style="border-radius:0 0 12px 12px;overflow:hidden;">
                @forelse($myLoanHistory as $loan)
                    <div class="list-group-item d-flex justify-content-between align-items-start gap-3" style="padding:12px 18px;border-color:var(--border);">
                        <div style="min-width:0;flex:1;">
                            <div style="font-weight:500;font-size:.875rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $loan->book->title }}</div>
                            <div style="font-size:.73rem;color:var(--muted);">Emprunté le {{ $loan->loaned_at->format('d/m/Y') }}</div>
                        </div>
                        @if($loan->returned_at)
                            <span class="badge text-bg-success" style="white-space:nowrap;flex-shrink:0;">Rendu {{ $loan->returned_at->format('d/m') }}</span>
                        @elseif($loan->isOverdue())
                            <span class="badge text-bg-danger" style="flex-shrink:0;">En retard</span>
                        @else
                            <span class="badge text-bg-warning" style="flex-shrink:0;">En cours</span>
                        @endif
                    </div>
                @empty
                    <div class="list-group-item" style="padding:24px 18px;color:var(--muted);font-size:.875rem;">Aucun historique pour le moment.</div>
                @endforelse
            </div>
        </div>

        {{-- Community activity --}}
        <div class="card">
            <div class="card-header">Activité récente</div>
            <div class="list-group list-group-flush" style="border-radius:0 0 12px 12px;overflow:hidden;">
                @forelse($communityLoans as $loan)
                    <div class="list-group-item d-flex justify-content-between align-items-start gap-3" style="padding:12px 18px;border-color:var(--border);">
                        <div style="min-width:0;flex:1;">
                            <div style="font-weight:500;font-size:.875rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $loan->book->title }}</div>
                            <div style="font-size:.73rem;color:var(--muted);">{{ $loan->user?->name ?? 'Utilisateur supprimé' }} · retour le {{ $loan->due_at->format('d/m/Y') }}</div>
                        </div>
                        @if($loan->isOverdue())
                            <span class="badge text-bg-danger" style="flex-shrink:0;">En retard</span>
                        @else
                            <span class="badge text-bg-warning" style="flex-shrink:0;">En cours</span>
                        @endif
                    </div>
                @empty
                    <div class="list-group-item" style="padding:24px 18px;color:var(--muted);font-size:.875rem;">Aucun emprunt global actif.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
