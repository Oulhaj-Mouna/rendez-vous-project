<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RDV Platform — @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <h1>RDV <span>Platform</span></h1>
        </div>

        <div class="sidebar-user">
            <div class="sidebar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <small>{{ auth()->user()->role }}</small>
                <p>{{ auth()->user()->name }}</p>
            </div>
        </div>

        <nav class="sidebar-nav">
            @if(auth()->user()->isAdmin())
                <div class="nav-section">Administration</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span> Dashboard
                </a>
                <a href="{{ route('admin.prestataires') }}" class="nav-link {{ request()->routeIs('admin.prestataires') ? 'active' : '' }}">
                    <span class="nav-icon">👨‍💼</span> Prestataires
                </a>
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <span class="nav-icon">👥</span> Clients
                </a>

            @elseif(auth()->user()->isPrestataire())
                <div class="nav-section">Mon Espace</div>
                <a href="{{ route('prestataire.dashboard') }}" class="nav-link {{ request()->routeIs('prestataire.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">🏠</span> Dashboard
                </a>
                <a href="{{ route('prestataire.agenda') }}" class="nav-link {{ request()->routeIs('prestataire.agenda') ? 'active' : '' }}">
                    <span class="nav-icon">📅</span> Mon Agenda
                </a>
                <a href="{{ route('prestataire.services') }}" class="nav-link {{ request()->routeIs('prestataire.services') ? 'active' : '' }}">
                    <span class="nav-icon">✂️</span> Mes Services
                </a>

            @else
                <div class="nav-section">Mon Espace</div>
                <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">🏠</span> Dashboard
                </a>
                <a href="{{ route('client.search') }}" class="nav-link {{ request()->routeIs('client.search*') ? 'active' : '' }}">
                    <span class="nav-icon">🔍</span> Chercher
                </a>
                <a href="{{ route('client.appointments') }}" class="nav-link {{ request()->routeIs('client.appointments') ? 'active' : '' }}">
                    <span class="nav-icon">📋</span> Mes RDV
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <span>🚪</span> Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-content">
        <div class="topbar">
            <span class="topbar-title">@yield('title')</span>
            <span class="topbar-badge">{{ ucfirst(auth()->user()->role) }}</span>
        </div>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">❌ {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>