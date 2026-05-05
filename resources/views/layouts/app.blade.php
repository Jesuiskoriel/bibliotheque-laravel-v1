<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bibliothèque Manager')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink:        #0D2137;
            --ink-mid:    #162f4a;
            --ink-hover:  rgba(255,255,255,.07);
            --amber:      #C8783A;
            --amber-glow: rgba(200,120,58,.14);
            --amber-text: #E09A60;
            --bg:         #F5F3EF;
            --card:       #FFFFFF;
            --border:     #E6E3DC;
            --text:       #1C1917;
            --muted:      #78716C;
            --sidebar-w:  256px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            background: var(--bg);
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--text);
            font-size: 15px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Sidebar ─────────────────────────────────── */
        .bib-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-w);
            background: var(--ink);
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }

        .bib-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 22px 18px 18px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            text-decoration: none;
        }

        .bib-brand-icon {
            width: 34px; height: 34px;
            background: var(--amber);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .bib-brand-icon svg { width: 18px; height: 18px; }

        .bib-brand-text { line-height: 1.25; }

        .bib-brand-name {
            font-family: 'DM Serif Display', Georgia, serif;
            font-style: italic;
            font-size: 1.05rem;
            color: #fff;
            display: block;
        }

        .bib-brand-sub {
            font-size: 0.6rem;
            color: rgba(255,255,255,.3);
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        .bib-nav {
            flex: 1;
            padding: 14px 10px;
        }

        .bib-nav-label {
            font-size: 0.58rem;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: rgba(255,255,255,.25);
            padding: 10px 10px 4px;
            margin-top: 4px;
            display: block;
        }

        .bib-nav-link {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: 7px;
            color: rgba(255,255,255,.58);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: background 160ms, color 160ms;
            cursor: pointer;
            white-space: nowrap;
        }

        .bib-nav-link svg {
            width: 17px; height: 17px;
            flex-shrink: 0;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .bib-nav-link:hover {
            background: var(--ink-hover);
            color: rgba(255,255,255,.85);
        }

        .bib-nav-link.active {
            background: var(--amber-glow);
            color: var(--amber-text);
        }

        /* ── User card bottom ────────────────────────── */
        .bib-user-panel {
            padding: 12px 10px;
            border-top: 1px solid rgba(255,255,255,.07);
        }

        .bib-user-inner {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 10px;
            border-radius: 8px;
            background: rgba(255,255,255,.05);
        }

        .bib-avatar {
            width: 30px; height: 30px;
            background: var(--amber);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .bib-user-name {
            font-size: 0.8rem;
            font-weight: 500;
            color: rgba(255,255,255,.8);
            line-height: 1.2;
        }

        .bib-user-role {
            font-size: 0.62rem;
            color: rgba(255,255,255,.3);
            text-transform: capitalize;
        }

        .bib-logout-btn {
            margin-left: auto;
            background: none;
            border: none;
            padding: 5px;
            color: rgba(255,255,255,.25);
            cursor: pointer;
            border-radius: 6px;
            transition: color 160ms, background 160ms;
            flex-shrink: 0;
        }

        .bib-logout-btn:hover {
            color: #f87171;
            background: rgba(248,113,113,.1);
        }

        .bib-logout-btn svg {
            width: 15px; height: 15px;
            stroke: currentColor; fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ── Main content ────────────────────────────── */
        .bib-main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
        }

        .bib-content {
            padding: 28px 32px;
        }

        /* ── Guest layout ────────────────────────────── */
        .bib-guest-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 28px;
            border-bottom: 1px solid var(--border);
            background: var(--card);
        }

        .bib-guest-logo {
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
        }

        .bib-guest-logo-icon {
            width: 30px; height: 30px;
            background: var(--ink);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }

        .bib-guest-logo-icon svg { width: 16px; height: 16px; }

        .bib-guest-logo-name {
            font-family: 'DM Serif Display', Georgia, serif;
            font-style: italic;
            font-size: 1rem;
            color: var(--ink);
        }

        .bib-guest-content {
            max-width: 520px;
            margin: 0 auto;
            padding: 48px 24px;
        }

        /* ── Alerts ──────────────────────────────────── */
        .bib-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 11px 14px;
            border-radius: 9px;
            font-size: 0.85rem;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .bib-alert svg {
            width: 16px; height: 16px;
            stroke: currentColor; fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .bib-alert-success { background: #DCFCE7; color: #15803D; border-left: 3px solid #15803D; }
        .bib-alert-danger  { background: #FEE2E2; color: #B91C1C; border-left: 3px solid #B91C1C; }

        /* ── Buttons (override Bootstrap) ───────────── */
        .btn { border-radius: 8px; font-size: 0.85rem; font-weight: 500; }
        .btn-primary, .btn-dark {
            background: var(--ink) !important;
            border-color: var(--ink) !important;
            color: #fff !important;
        }
        .btn-primary:hover, .btn-dark:hover {
            background: var(--ink-mid) !important;
            border-color: var(--ink-mid) !important;
        }
        .btn-outline-secondary { border-color: var(--border); color: var(--muted); }
        .btn-outline-secondary:hover { background: var(--bg); color: var(--text); border-color: var(--border); }
        .btn-outline-success { border-color: #16a34a; color: #16a34a; }
        .btn-outline-success:hover { background: #f0fdf4; color: #15803d; }
        .btn-outline-danger { border-color: #dc2626; color: #dc2626; }
        .btn-outline-danger:hover { background: #fef2f2; color: #b91c1c; }

        /* ── Form inputs (override Bootstrap) ───────── */
        .form-control, .form-select {
            border-radius: 8px;
            border-color: var(--border);
            font-size: 0.875rem;
            color: var(--text);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--ink);
            box-shadow: 0 0 0 3px rgba(13,33,55,.08);
        }
        .form-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 5px;
        }

        /* ── Tables (override Bootstrap) ────────────── */
        .table {
            --bs-table-hover-bg: #FAFAF8;
            font-size: 0.875rem;
        }
        .table > thead > tr > th {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: .09em;
            color: var(--muted);
            font-weight: 600;
            background: #FAFAF7;
            border-bottom-color: var(--border);
            white-space: nowrap;
            padding: 11px 14px;
        }
        .table > tbody > tr > td {
            border-bottom-color: var(--border);
            vertical-align: middle;
            padding: 12px 14px;
            color: var(--text);
        }
        .table > tbody > tr:last-child > td { border-bottom: 0; }
        .table-responsive { border-radius: 0 0 12px 12px; }

        /* ── Badges (override Bootstrap) ────────────── */
        .badge { border-radius: 20px; font-weight: 500; letter-spacing: .02em; }
        .text-bg-success { background: #DCFCE7 !important; color: #15803D !important; }
        .text-bg-danger  { background: #FEE2E2 !important; color: #B91C1C !important; }
        .text-bg-warning { background: #FEF3C7 !important; color: #B45309 !important; }
        .text-bg-secondary { background: #F1F5F9 !important; color: #64748B !important; }

        /* ── Cards (override Bootstrap) ─────────────── */
        .card, .card-soft {
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
        }
        .card-header {
            border-bottom-color: var(--border);
            background: #FAFAF7 !important;
            border-radius: 12px 12px 0 0 !important;
            padding: 14px 18px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .card-body { padding: 18px; }

        /* ── Pagination ──────────────────────────────── */
        .pagination .page-link {
            border-radius: 7px !important;
            border-color: var(--border);
            color: var(--text);
            font-size: 0.82rem;
            margin: 0 2px;
        }
        .pagination .page-link:hover { background: var(--bg); color: var(--ink); }
        .pagination .active .page-link {
            background: var(--ink) !important;
            border-color: var(--ink) !important;
        }

        /* ── Responsive ──────────────────────────────── */
        @media (max-width: 767px) {
            .bib-sidebar { display: none; }
            .bib-main { margin-left: 0; }
            .bib-content { padding: 16px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition: none !important; animation: none !important; }
        }
    </style>
</head>
<body>

@auth
<div style="display:flex; min-height:100vh;">

    <aside class="bib-sidebar">
        <a class="bib-brand" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
            <div class="bib-brand-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
            <div class="bib-brand-text">
                <span class="bib-brand-name">Bibliothèque</span>
                <span class="bib-brand-sub">Manager</span>
            </div>
        </a>

        <nav class="bib-nav">
            @if(auth()->user()->role === 'admin')
                <span class="bib-nav-label">Navigation</span>
                <a class="bib-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <svg viewBox="0 0 24 24"><path d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    Tableau de bord
                </a>

                <span class="bib-nav-label">Catalogue</span>
                <a class="bib-nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">
                    <svg viewBox="0 0 24 24"><path d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                    Livres
                </a>
                <a class="bib-nav-link {{ request()->routeIs('authors.*') ? 'active' : '' }}" href="{{ route('authors.index') }}">
                    <svg viewBox="0 0 24 24"><path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                    Auteurs
                </a>
                <a class="bib-nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                    <svg viewBox="0 0 24 24"><path d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/><path d="M6 6h.008v.008H6V6Z"/></svg>
                    Catégories
                </a>

                <span class="bib-nav-label">Gestion</span>
                <a class="bib-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <svg viewBox="0 0 24 24"><path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                    Utilisateurs
                </a>
                <a class="bib-nav-link {{ request()->routeIs('loans.*') ? 'active' : '' }}" href="{{ route('loans.index') }}">
                    <svg viewBox="0 0 24 24"><path d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                    Emprunts / Retours
                </a>
            @else
                <a class="bib-nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                    <svg viewBox="0 0 24 24"><path d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    Mon espace
                </a>
            @endif
        </nav>

        <div class="bib-user-panel">
            <div class="bib-user-inner">
                <div class="bib-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</div>
                <div style="min-width:0; flex:1;">
                    <div class="bib-user-name" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ auth()->user()->name }}</div>
                    <div class="bib-user-role">{{ auth()->user()->role }}</div>
                </div>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bib-logout-btn" title="Déconnexion">
                        <svg viewBox="0 0 24 24"><path d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="bib-main" style="flex:1;">
        <div class="bib-content">
            @if(session('success'))
                <div class="bib-alert bib-alert-success">
                    <svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bib-alert bib-alert-danger">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                    <ul class="mb-0 ps-2">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>

@else

<div>
    <div class="bib-guest-bar">
        <a class="bib-guest-logo" href="{{ route('login') }}">
            <div class="bib-guest-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>
            <span class="bib-guest-logo-name">Bibliothèque</span>
        </a>
        <div class="d-flex gap-2">
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Connexion</a>
            <a class="btn btn-sm btn-dark" href="{{ route('register') }}">Créer un compte</a>
        </div>
    </div>
    <div class="bib-guest-content">
        @if(session('success'))
            <div class="bib-alert bib-alert-success">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bib-alert bib-alert-danger">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                <ul class="mb-0 ps-2">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        @yield('content')
    </div>
</div>

@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
