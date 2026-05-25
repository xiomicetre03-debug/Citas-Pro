@extends('layouts.app')

@section('title', 'Especialistas')

@section('content')
<section class="grid-two">
    <article class="panel">
        <h2>Nuevo especialista</h2>
        <form method="POST" action="{{ route('especialistas.store') }}" enctype="multipart/form-data" class="form">
            @csrf
            <label>Nombre <input name="nombre" value="{{ old('nombre') }}" required></label>
            <label>Especialidad <input name="especialidad" value="{{ old('especialidad') }}" required></label>
            <label>Telefono <input name="telefono" value="{{ old('telefono') }}" required></label>
            <label>Foto <input type="file" name="foto" accept="image/*"></label>
            <button class="btn primary">Guardar</button>
        </form>
    </article>

    <article class="panel">
        <h2>Especialistas</h2>
        <div class="table-wrap">
            <table data-datatable data-page-size="6">
                <thead><tr><th>Foto</th><th>Nombre</th><th>Especialidad</th><th>Telefono</th><th>Acciones</th></tr></thead>
                <tbody>
                    @foreach($especialistas as $especialista)
                        <tr>
                            <td>
                                @if($especialista->foto)
                                    <img class="avatar" src="{{ asset('storage/' . $especialista->foto) }}" alt="">
                                @endif
                            </td>
                            <td>{{ $especialista->nombre }}</td>
                            <td>{{ $especialista->especialidad }}</td>
                            <td>{{ $especialista->telefono }}</td>
                            <td class="actions-cell">
                                <a class="btn small" href="{{ route('especialistas.edit', $especialista) }}">Editar</a>
                                <form method="POST" action="{{ route('especialistas.destroy', $especialista) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn danger small">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </article>
</section>
@endsection