@extends('layouts.app')

@section('title', 'Recuperar contrasena')

@section('content')
<section class="auth-card">
    <h1>Recuperar contrasena</h1>

    <form method="POST" action="{{ route('password.recover') }}" class="form">
        @csrf

        <label>Correo
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>

        <button class="btn primary">Enviar instrucciones</button>
    </form>

    <div class="auth-links">
        <a href="{{ route('login') }}">Volver al login</a>
    </div>

</section>
@endsection