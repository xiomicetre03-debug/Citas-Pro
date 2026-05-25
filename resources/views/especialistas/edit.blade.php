@extends('layouts.app')

@section('title', 'Editar especialista')

@section('content')
<section class="panel narrow">
    <h2>Editar especialista</h2>
    <form method="POST" action="{{ route('especialistas.update', $especialista) }}" enctype="multipart/form-data" class="form">
        @csrf
        @method('PUT')
        @if($especialista->foto)
            <img class="profile-photo" src="{{ asset('storage/' . $especialista->foto) }}" alt="">
        @endif
        <label>Nombre <input name="nombre" value="{{ old('nombre', $especialista->nombre) }}" required></label>
        <label>Especialidad <input name="especialidad" value="{{ old('especialidad', $especialista->especialidad) }}" required></label>
        <label>Telefono <input name="telefono" value="{{ old('telefono', $especialista->telefono) }}" required></label>
        <label>Foto <input type="file" name="foto" accept="image/*"></label>
        <button class="btn primary">Actualizar</button>
    </form>
</section>
@endsection