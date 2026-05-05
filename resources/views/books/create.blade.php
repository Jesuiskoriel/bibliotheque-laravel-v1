@extends('layouts.app')
@section('title', 'Ajouter un livre')
@section('content')

<div class="mb-4">
    <a href="{{ route('books.index') }}" style="font-size:.82rem;color:var(--muted);text-decoration:none;display:inline-flex;align-items:center;gap:5px;margin-bottom:12px;transition:color 160ms;" onmouseover="this.style.color='var(--ink)'" onmouseout="this.style.color='var(--muted)'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        Retour aux livres
    </a>
    <h1 style="font-family:'DM Serif Display',Georgia,serif;font-size:1.6rem;margin:0;color:var(--text);">Ajouter un livre</h1>
</div>

<div class="card" style="max-width:580px;">
    <div class="card-body">
        <form method="post" action="{{ route('books.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="title">Titre</label>
                <input class="form-control" id="title" name="title" type="text" value="{{ old('title') }}" placeholder="Ex. Le Petit Prince" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="isbn">ISBN</label>
                <input class="form-control" id="isbn" name="isbn" type="text" value="{{ old('isbn') }}" placeholder="978-...">
            </div>
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label" for="published_year">Année de publication</label>
                    <input class="form-control" id="published_year" name="published_year" type="number" value="{{ old('published_year') }}" placeholder="{{ date('Y') }}" min="1000" max="{{ date('Y') }}">
                </div>
                <div class="col-6">
                    <label class="form-label" for="stock_total">Exemplaires</label>
                    <input class="form-control" id="stock_total" name="stock_total" type="number" value="{{ old('stock_total', 1) }}" min="1" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="author_id">Auteur</label>
                <select class="form-select" id="author_id" name="author_id" required>
                    <option value="">Sélectionner un auteur</option>
                    @foreach($authors as $a)
                        <option value="{{ $a->id }}" {{ old('author_id') == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label" for="category_id">Catégorie</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-dark" type="submit">Enregistrer</button>
                <a class="btn btn-outline-secondary" href="{{ route('books.index') }}">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection
