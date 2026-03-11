@extends('layouts.app')
@section('content')
<form method="post" action="{{ route('authors.store') }}">@csrf<input name="name" class="form-control mb-2" placeholder="Nom"><textarea name="bio" class="form-control mb-2"></textarea><button class="btn btn-primary">Save</button></form>
@endsection