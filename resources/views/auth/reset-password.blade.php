@extends('layouts.app')

@section('title', 'Nueva contrasena')

@section('content')
<section class="auth-card">
    <h1>Nueva contrasena</h1>
    <form method="POST" action="{{ route('password.update') }}" class="form">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <label>Correo
            <input type="email" name="email" value="{{ old('email', $email) }}" required>
        </label>
        <label>Nueva contrasena
            <input type="password" name="password" minlength="6" required>
        </label>
        <label>Confirmar contrasena
            <input type="password" name="password_confirmation" minlength="6" required>
        </label>
        <button class="btn primary">Actualizar contrasena</button>
    </form>
</section>
@endsection