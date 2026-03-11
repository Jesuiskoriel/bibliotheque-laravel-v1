@extends('layouts.app')
@section('content')
<h1 class="h3 mb-3">Tableau de bord</h1>
<div class="row g-3 mb-4"><div class="col"><div class="card"><div class="card-body">Livres: {{ $stats['books'] }}</div></div></div><div class="col"><div class="card"><div class="card-body">Adhérents: {{ $stats['members'] }}</div></div></div><div class="col"><div class="card"><div class="card-body">Emprunts: {{ $stats['active_loans'] }}</div></div></div><div class="col"><div class="card"><div class="card-body">Retards: {{ $stats['overdue_loans'] }}</div></div></div></div>
@endsection
