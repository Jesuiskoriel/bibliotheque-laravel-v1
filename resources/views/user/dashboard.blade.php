{{-- METAL-EXPLAIN: Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<h1 class="h4 mb-3">Espace utilisateur</h1>
<div class="card mb-3"><div class="card-header">Catalogue (aperÃ§u)</div><div class="table-responsive"><table class="table mb-0"><thead><tr><th>Titre</th><th>Auteur</th><th>CatÃ©gorie</th><th>Disponibles</th></tr></thead><tbody>@foreach($books as $book)<tr><td>{{ $book->title }}</td><td>{{ $book->author->name }}</td><td>{{ $book->category->name }}</td><td>{{ $book->stock_available }}/{{ $book->stock_total }}</td></tr>@endforeach</tbody></table></div></div>
<div class="card"><div class="card-header">Emprunts en cours (global)</div><div class="table-responsive"><table class="table mb-0"><thead><tr><th>Livre</th><th>Retour prÃ©vu</th><th>Statut</th></tr></thead><tbody>@foreach($activeLoans as $loan)<tr><td>{{ $loan->book->title }}</td><td>{{ $loan->due_at->format('d/m/Y') }}</td><td>@if($loan->isOverdue())<span class='badge text-bg-danger'>En retard</span>@else<span class='badge text-bg-warning'>En cours</span>@endif</td></tr>@endforeach</tbody></table></div></div>
@endsection

