@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Utilisateurs</h1>
    <span class="text-muted small">{{ $users->total() }} compte(s)</span>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card card-soft h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Comptes utilisateurs</div>
                <div class="h4 mb-0">{{ $totalUsers }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-soft h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Comptes actifs</div>
                <div class="h4 mb-0 text-success">{{ $activeUsers }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-soft h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Comptes bannis</div>
                <div class="h4 mb-0 text-danger">{{ $bannedUsers }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card card-soft mb-3">
    <div class="card-body">
        <form method="get" action="{{ route('admin.users.index') }}" class="row g-2 align-items-end">
            <div class="col-md-6">
                <label for="q" class="form-label">Recherche</label>
                <input id="q" name="q" type="text" value="{{ request('q') }}" class="form-control" placeholder="Nom ou email">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Statut</label>
                <select id="status" name="status" class="form-select">
                    <option value="">Tous</option>
                    <option value="active" @selected(request('status') === 'active')>Actifs</option>
                    <option value="banned" @selected(request('status') === 'banned')>Bannis</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-dark w-100" type="submit">Filtrer</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">Réinitialiser</a>
            </div>
        </form>
    </div>
</div>

<div class="card card-soft">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Total empruntés</th>
                    <th>En cours</th>
                    <th>Statut</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <a href="{{ route('admin.users.show', $user) }}" class="fw-semibold text-decoration-none">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->total_empruntes }}</td>
                        <td>{{ $user->en_cours }}</td>
                        <td>
                            @if($user->is_blocked)
                                <span class="badge text-bg-danger">Banni</span>
                            @else
                                <span class="badge text-bg-success">Actif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-secondary me-2">
                                Voir
                            </a>
                            <form method="post" action="{{ route('admin.users.toggle-block', $user) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm {{ $user->is_blocked ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                    onclick="return confirm('Confirmer cette action sur le compte ?')">
                                    {{ $user->is_blocked ? 'Débannir' : 'Bannir' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Aucun utilisateur trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body border-top">
        {{ $users->links() }}
    </div>
</div>
@endsection
