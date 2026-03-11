<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bibliothèque Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg bg-dark navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">📚 Bibliothèque</a>
        <div class="navbar-nav">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="nav-link" href="{{ route('books.index') }}">Livres</a>
                    <a class="nav-link" href="{{ route('authors.index') }}">Auteurs</a>
                    <a class="nav-link" href="{{ route('categories.index') }}">Catégories</a>
                    <a class="nav-link" href="{{ route('members.index') }}">Adhérents</a>
                    <a class="nav-link" href="{{ route('loans.index') }}">Retours/Emprunts</a>
                @else
                    <a class="nav-link" href="{{ route('user.dashboard') }}">Espace utilisateur</a>
                @endif
            @endauth
        </div>
        <div>
            @auth
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-light">Déconnexion</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    @yield('content')
</div>
</body>
</html>
