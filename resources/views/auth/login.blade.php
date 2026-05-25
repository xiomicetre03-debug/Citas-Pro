@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section class="auth-card">
    <h1>Iniciar sesion</h1>

    <form method="POST" action="{{ route('login.store') }}" class="form">
        @csrf

        <label>Correo
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>

        <label>Contrasena
            <input type="password" name="password" required>
        </label>

        <button class="btn primary">Entrar</button>
    </form>

    <div class="auth-links">
        <a href="{{ route('password.request') }}">Recuperar contrasena</a>
        <span>·</span>
        <a href="{{ route('register') }}">Registrarme</a>
    </div>

</section>
@endsection