@extends('layouts.app')
@section('title', 'Nouvel emprunt')
@section('content')

<div class="mb-4">
    <a href="{{ route('admin.dashboard') }}" style="font-size:.82rem;color:var(--muted);text-decoration:none;display:inline-flex;align-items:center;gap:5px;margin-bottom:12px;transition:color 160ms;" onmouseover="this.style.color='var(--ink)'" onmouseout="this.style.color='var(--muted)'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        Retour
    </a>
    <h1 style="font-family:'DM Serif Display',Georgia,serif;font-size:1.6rem;margin:0;color:var(--text);">Nouvel emprunt</h1>
</div>

<div class="card" style="max-width:560px;">
    <div class="card-body">
        <form method="post" action="{{ route('loans.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="book_id">Livre</label>
                <select class="form-select" id="book_id" name="book_id" required>
                    <option value="">Sélectionner un livre</option>
                    @foreach($books as $b)
                        <option value="{{ $b->id }}">{{ $b->title }} — {{ $b->stock_available }} dispo</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="user_id">Utilisateur</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <option value="">Sélectionner un utilisateur</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label" for="loaned_at">Date du prêt</label>
                    <input class="form-control" id="loaned_at" name="loaned_at" type="date" value="{{ now()->toDateString() }}" required>
                </div>
                <div class="col-6">
                    <label class="form-label" for="due_at">Retour prévu</label>
                    <input class="form-control" id="due_at" name="due_at" type="date" value="{{ now()->addDays(14)->toDateString() }}" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label" for="notes">Notes internes</label>
                <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Optionnel…"></textarea>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-dark" type="submit">Enregistrer</button>
                <a class="btn btn-outline-secondary" href="{{ route('loans.index') }}">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection
