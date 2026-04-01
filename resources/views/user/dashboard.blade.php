{{-- Cette vue affiche l'interface.
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
    <div>
        <p class="text-uppercase text-muted small mb-1">Espace utilisateur</p>
        <h1 class="h3 mb-1">Bienvenue {{ auth()->user()->name }}</h1>
        <p class="text-muted mb-0">Consultez le catalogue, empruntez un livre disponible et suivez vos retours.</p>
    </div>
    <form method="get" action="{{ route('user.dashboard') }}" class="d-flex gap-2">
        <input class="form-control" type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher un titre, auteur, catégorie">
        <button class="btn btn-dark" type="submit">Rechercher</button>
    </form>
</div>

@if($errors->has('borrow'))
    <div class="alert alert-danger">{{ $errors->first('borrow') }}</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-soft h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Livres disponibles</div>
                <div class="display-6 fw-semibold">{{ $books->total() }}</div>
                <div class="text-muted">résultats dans le catalogue</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-soft h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Livres déjà empruntés</div>
                <div class="display-6 fw-semibold">{{ $myTotalBorrowed }}</div>
                <div class="text-muted">sur tout votre historique</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-soft h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Mes emprunts actifs</div>
                <div class="display-6 fw-semibold">{{ $myActiveLoans->count() }}</div>
                <div class="text-muted">livres à rendre prochainement</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-soft h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Livres rendus</div>
                <div class="display-6 fw-semibold">{{ $myReturnedLoans }}</div>
                <div class="text-muted">emprunts terminés</div>
            </div>
        </div>
    </div>
</div>

<div class="card card-soft mb-4">
    <div class="card-header bg-white fw-semibold">Catalogue</div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Auteur</th>
                    <th>Catégorie</th>
                    <th>Disponibilité</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($books as $book)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $book->title }}</div>
                        <div class="text-muted small">ISBN {{ $book->isbn }}</div>
                    </td>
                    <td>{{ $book->author->name }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>
                        @if($book->is_available)
                            <span class="badge text-bg-success">{{ $book->stock_available }}/{{ $book->stock_total }} disponible(s)</span>
                        @else
                            <span class="badge text-bg-secondary">Indisponible</span>
                        @endif
                    </td>
                    <td class="text-end">
                        @php
                            $alreadyBorrowed = $myActiveLoans->contains('book_id', $book->id);
                        @endphp
                        @if($alreadyBorrowed)
                            <span class="badge text-bg-warning">Déjà emprunté</span>
                        @elseif($book->is_available)
                            <form method="post" action="{{ route('user.loans.store') }}">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button class="btn btn-sm btn-dark" type="submit">Emprunter</button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-outline-secondary" type="button" disabled>Non disponible</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucun livre trouvé.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($books->hasPages())
        <div class="card-body border-top">{{ $books->links() }}</div>
    @endif
</div>

<div class="row g-4">
    <div class="col-xl-7">
        <div class="card card-soft h-100">
            <div class="card-header bg-white fw-semibold">Mes emprunts en cours</div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Livre</th><th>Retour prévu</th><th>Statut</th><th class="text-end">Action</th></tr></thead>
                    <tbody>
                    @forelse($myActiveLoans as $loan)
                        <tr>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ $loan->due_at->format('d/m/Y') }}</td>
                            <td>
                                @if($loan->isOverdue())
                                    <span class="badge text-bg-danger">En retard</span>
                                @else
                                    <span class="badge text-bg-warning">En cours</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <form method="post" action="{{ route('user.loans.return', $loan) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-outline-success" type="submit">Marquer rendu</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Aucun emprunt actif.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card card-soft mb-4">
            <div class="card-header bg-white fw-semibold">Historique personnel</div>
            <div class="list-group list-group-flush">
                @forelse($myLoanHistory as $loan)
                    <div class="list-group-item d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <div class="fw-semibold">{{ $loan->book->title }}</div>
                            <div class="text-muted small">Emprunté le {{ $loan->loaned_at->format('d/m/Y') }}</div>
                        </div>
                        @if($loan->returned_at)
                            <span class="badge text-bg-success">Rendu le {{ $loan->returned_at->format('d/m/Y') }}</span>
                        @elseif($loan->isOverdue())
                            <span class="badge text-bg-danger">En retard</span>
                        @else
                            <span class="badge text-bg-warning">En cours</span>
                        @endif
                    </div>
                @empty
                    <div class="list-group-item text-muted py-4">Aucun historique pour le moment.</div>
                @endforelse
            </div>
        </div>

        <div class="card card-soft">
            <div class="card-header bg-white fw-semibold">Activité récente de la bibliothèque</div>
            <div class="list-group list-group-flush">
                @forelse($communityLoans as $loan)
                    <div class="list-group-item d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <div class="fw-semibold">{{ $loan->book->title }}</div>
                            <div class="text-muted small">{{ $loan->user?->name ?? 'Utilisateur supprimé' }} • retour prévu le {{ $loan->due_at->format('d/m/Y') }}</div>
                        </div>
                        @if($loan->isOverdue())
                            <span class="badge text-bg-danger">En retard</span>
                        @else
                            <span class="badge text-bg-warning">En cours</span>
                        @endif
                    </div>
                @empty
                    <div class="list-group-item text-muted py-4">Aucun emprunt global actif.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
