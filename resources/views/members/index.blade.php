{{-- METAL-EXPLAIN: Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'Ã©cran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<a class="btn btn-primary mb-2" href="{{ route('members.Créer') }}">Ajouter adhÃƒÂ©rent</a>
<table class="table">@foreach($members as $member)<tr><td>{{ $member->full_name }}</td><td>{{ $member->email }}</td><td><a href="{{ route('members.Modifier',$member) }}">Modifier</a></td></tr>@endforeach</table>
@endsection

