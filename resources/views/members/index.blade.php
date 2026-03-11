@extends('layouts.app')
@section('content')
<a class="btn btn-primary mb-2" href="{{ route('members.create') }}">Ajouter adhérent</a>
<table class="table">@foreach($members as $member)<tr><td>{{ $member->full_name }}</td><td>{{ $member->email }}</td><td><a href="{{ route('members.edit',$member) }}">Edit</a></td></tr>@endforeach</table>
@endsection