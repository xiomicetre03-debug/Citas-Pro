@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
<section class="panel narrow">
    <h2>Perfil de usuario</h2>
    <form method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data" class="form">
        @csrf
        @method('PUT')
        @if($user->photo)
            <img class="profile-photo" src="{{ asset('storage/' . $user->photo) }}" alt="">
        @endif
        <label>Nombre <input name="name" value="{{ old('name', $user->name) }}" required></label>
        <label>Correo <input type="email" name="email" value="{{ old('email', $user->email) }}" required></label>
        <label>Nueva contrasena <input type="password" name="password" placeholder="Dejar vacio para conservar"></label>
        <label>Foto <input type="file" name="photo" accept="image/*"></label>
        <button class="btn primary">Actualizar perfil</button>
    </form>
</section>
@endsection