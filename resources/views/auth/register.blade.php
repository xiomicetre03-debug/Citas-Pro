@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<section class="auth-card">
    <h1>Registro</h1>

    <form method="POST" action="{{ route('register.store') }}" class="form">
        @csrf

        <label>Nombre
            <input name="name" value="{{ old('name') }}" required>
        </label>

        <label>Correo
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>

        <label>Contrasena
            <input type="password" name="password" minlength="6" required>
        </label>

        <button class="btn primary">Crear cuenta</button>
    </form>

    <div class="auth-links">
        <a href="{{ route('login') }}">Ya tengo cuenta</a>
    </div>

</section>
@endsection