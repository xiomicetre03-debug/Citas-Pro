@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<section class="panel">
    <h2>Usuarios registrados</h2>

    <div class="table-wrap">
        <table data-datatable data-page-size="8">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>
                            @if($usuario->photo)
                                <img class="avatar" src="{{ asset('storage/' . $usuario->photo) }}" alt="Foto de {{ $usuario->name }}">
                            @else
                                <span class="muted">Sin foto</span>
                            @endif
                        </td>

                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td><span class="badge">{{ $usuario->role }}</span></td>
                        <td>{{ $usuario->created_at?->format('Y-m-d') }}</td>

                        <td>
                            @if($usuario->id !== auth()->id())
                                <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn danger small"
                                        onclick="return confirm('¿Seguro que deseas eliminar este usuario?')"
                                    >
                                        Eliminar
                                    </button>
                                </form>
                            @else
                                <span class="muted">Usuario actual</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection