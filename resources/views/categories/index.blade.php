{{-- Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'Ã©cran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<a class="btn btn-primary mb-2" href="{{ route('categories.Créer') }}">Ajouter catÃƒÂ©gorie</a>
<table class="table">@foreach($categories as $category)<tr><td>{{ $category->name }}</td><td><a href="{{ route('categories.Modifier',$category) }}">Modifier</a></td></tr>@endforeach</table>
@endsection

