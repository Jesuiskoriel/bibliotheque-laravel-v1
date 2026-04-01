@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Utilisateurs</h1>
    <span class="text-muted small">{{ $users->total() }} compte(s)</span>
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
                                <span class="badge text-bg-danger">Bloqué</span>
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
                                <button class="btn btn-sm {{ $user->is_blocked ? 'btn-outline-success' : 'btn-outline-danger' }}">
                                    {{ $user->is_blocked ? 'Débloquer' : 'Bloquer' }}
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
