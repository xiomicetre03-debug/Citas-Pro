<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de Citas')</title>
    <link rel="icon" href="img/cita.png" type="img/png">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/datatables.js') }}" defer></script>
</head>
<body>
    @guest
    <a class="guest-home-btn" href="{{ route('landing') }}">Inicio</a>
@endguest
    @auth
        <aside class="sidebar">
            <div class="brand">CitasPro</div>
            <nav>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                 @if(auth()->user()->role === 'admin')
                    <a href="{{ route('especialistas.index') }}">Especialistas</a>
                    <a href="{{ route('usuarios.index') }}">Usuarios</a>
                @endif
                <a href="{{ route('citas.index') }}">Citas</a>
                <a href="{{ route('perfil.index') }}">Perfil</a>
                  @if(auth()->user()->role === 'admin')
                    <a href="{{ route('reporte.pdf') }}">Reportes PDF</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button>Logout</button>
                </form>
            </nav>
        </aside>
    @endauth

    <main class="main @auth with-sidebar @endauth">
        @auth
            <header class="topbar">
                <div>
                    <span class="muted">Bienvenido</span>
                    <h1>@yield('title', 'Dashboard')</h1>
                </div>
                <div class="user-chip">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="">
                    @endif
                    <span>{{ auth()->user()->name }}</span>
                </div>
            </header>
        @endauth

        @if(session('status'))
            <div class="alert success">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="alert error">{{ $errors->first() }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>