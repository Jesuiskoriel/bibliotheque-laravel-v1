{{-- METAL-EXPLAIN: Cette vue affiche l'interface. 
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
@extends('layouts.app')
@section('content')
<form method="post" action="{{ route('members.update',$member) }}">@csrf @method('PUT')<input class="form-control mb-2" name="first_name" value="{{ $member->first_name }}"><input class="form-control mb-2" name="last_name" value="{{ $member->last_name }}"><input class="form-control mb-2" name="email" value="{{ $member->email }}"><input class="form-control mb-2" name="phone" value="{{ $member->phone }}"><button class="btn btn-primary">Save</button></form>
@endsection
