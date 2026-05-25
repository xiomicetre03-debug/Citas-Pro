@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<section class="landing">
    <div>
        <p class="eyebrow">Sistema de gestion de citas</p>
        <h1>Agenda, especialistas y reportes en un solo panel.</h1>
        <p>Registra usuarios, administra especialistas, crea citas, consulta graficas y descarga reportes PDF.</p>
        <div class="actions">
            <a class="btn primary" href="{{ route('register') }}">Crear cuenta</a>
            <a class="btn" href="{{ route('login') }}">Iniciar sesion</a>
        </div>
    </div>
</section>
@endsection