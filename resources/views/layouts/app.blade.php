{{-- Cette vue affiche l'interface.
   Version simple: ce fichier dessine l'écran que l'utilisateur voit. --}}
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bibliothèque Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f4f7fb; }
        .app-shell { min-height:100vh; }
        .sidebar { background:#111827; min-height:100vh; }
        .sidebar .nav-link { color:#c8d2e6; border-radius:10px; }
        .sidebar .nav-link.active,.sidebar .nav-link:hover { background:#1f2937; color:#fff; }
        .card-soft { border:0; border-radius:14px; box-shadow:0 8px 24px rgba(15,23,42,.06); }
    </style>
</head>
<body>
<div class="container-fluid app-shell">
    <div class="row">
        @auth
            <aside class="col-lg-2 col-md-3 sidebar p-3">
                <div class="text-white fw-bold mb-3">Bibliothèque</div>
                <div class="nav flex-column gap-1">
                    @if(auth()->user()->role === 'admin')
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Tableau de bord</a>
                        <a class="nav-link" href="{{ route('books.index') }}">Livres</a>
                        <a class="nav-link" href="{{ route('authors.index') }}">Auteurs</a>
                        <a class="nav-link" href="{{ route('categories.index') }}">Catégories</a>
                        <a class="nav-link" href="{{ route('loans.index') }}">Emprunts/Retours</a>
                    @else
                        <a class="nav-link" href="{{ route('user.dashboard') }}">Espace utilisateur</a>
                    @endif
                </div>
            </aside>
        @endauth

        <main class="@auth col-lg-10 col-md-9 @else col-12 @endauth p-3 p-lg-4">
            @guest
                <div class="d-flex justify-content-end align-items-center gap-2 mb-4">
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('login') }}">Connexion</a>
                    <a class="btn btn-dark btn-sm" href="{{ route('register') }}">Créer un compte</a>
                </div>
            @endguest
            @auth
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-muted small">Connecté : {{ auth()->user()->name }} ({{ auth()->user()->role }})</div>
                    <form method="post" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-danger btn-sm">Déconnexion</button></form>
                </div>
            @endauth

            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
