@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <a href="{{ route('admin.users.index') }}" class="text-decoration-none small">← Retour aux utilisateurs</a>
        <h1 class="h3 mb-0 mt-1">{{ $user->name }}</h1>
        <div class="text-muted">{{ $user->email }}</div>
    </div>
    <div>
        @if($user->is_blocked)
            <span class="badge text-bg-danger">Compte bloqué</span>
        @else
            <span class="badge text-bg-success">Compte actif</span>
        @endif
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-soft h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Total empruntés</div>
                <div class="display-6 fw-semibold">{{ $user->total_empruntes }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-soft h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Emprunts en cours</div>
                <div class="display-6 fw-semibold">{{ $user->en_cours }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-soft h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Livres rendus</div>
                <div class="display-6 fw-semibold">{{ $user->total_rendus }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-6">
        <div class="card card-soft h-100">
            <div class="card-header bg-white fw-semibold">Emprunts en cours</div>
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Livre</th>
                            <th>Date prêt</th>
                            <th>Retour prévu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeLoans as $loan)
                            <tr>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->loaned_at->format('d/m/Y') }}</td>
                                <td>{{ $loan->due_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">Aucun emprunt actif.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-body border-top">
                {{ $activeLoans->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card card-soft h-100">
            <div class="card-header bg-white fw-semibold">Historique des emprunts</div>
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Livre</th>
                            <th>Date prêt</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loanHistory as $loan)
                            <tr>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->loaned_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($loan->returned_at)
                                        <span class="badge text-bg-success">Rendu</span>
                                    @else
                                        <span class="badge text-bg-warning">En cours</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">Aucun historique.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-body border-top">
                {{ $loanHistory->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
