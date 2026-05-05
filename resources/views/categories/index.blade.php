@extends('layouts.app')
@section('title', 'Catégories')
@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <p class="text-uppercase mb-1" style="font-size:.65rem;letter-spacing:.1em;color:var(--muted);font-weight:600;">Catalogue</p>
        <h1 style="font-family:'DM Serif Display',Georgia,serif;font-size:1.6rem;margin:0;color:var(--text);">Catégories</h1>
    </div>
    <a class="btn btn-sm btn-dark" href="{{ route('categories.create') }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:5px;"><path d="M12 5v14M5 12h14"/></svg>
        Ajouter une catégorie
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>
                        <span style="font-size:.78rem;background:var(--amber-glow, rgba(200,120,58,.1));color:var(--amber);padding:3px 11px;border-radius:20px;font-weight:500;">{{ $category->name }}</span>
                    </td>
                    <td style="text-align:right;">
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('categories.edit', $category) }}" style="cursor:pointer;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:3px;"><path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/></svg>
                            Modifier
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align:center;padding:40px;color:var(--muted);font-size:.875rem;">
                        Aucune catégorie.
                        <a href="{{ route('categories.create') }}" style="color:var(--amber);text-decoration:none;font-weight:500;">Ajouter la première</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
