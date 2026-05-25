@extends('layouts.app')

@section('title', 'Citas')

@section('content')
<section class="grid-two">
    <article class="panel">
        @if(auth()->user()->role === 'admin')
            <h2>Gestionar solicitudes</h2>
            <p class="muted">
                Selecciona una cita pendiente en la tabla para asignar especialista, fecha, hora y estado.
            </p>
        @else
            <h2>Solicitar cita</h2>

            <form method="POST" action="{{ route('citas.store') }}" class="form">
                @csrf

                <label>Motivo de la cita
                    <textarea name="motivo" required>{{ old('motivo') }}</textarea>
                </label>

                <button class="btn primary">Enviar solicitud</button>
            </form>
        @endif
    </article>

    <article class="panel">
        <h2>Lista de citas</h2>

        <div class="table-wrap">
            <table data-datatable data-page-size="6">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Especialista</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($citas as $cita)
                        <tr>
                            <td>{{ $cita->user->name }}</td>

                            <td>{{ $cita->especialista?->nombre ?? 'Por asignar' }}</td>

                            <td>
                                {{ $cita->fecha ? $cita->fecha->format('Y-m-d') : 'Por asignar' }}
                            </td>

                            <td>
                                {{ $cita->hora ? substr($cita->hora, 0, 5) : 'Por asignar' }}
                            </td>

                            <td>
                                <span class="badge">{{ ucfirst($cita->estado) }}</span>
                            </td>

                            <td class="actions-cell">
                                <a class="btn small" href="{{ route('citas.pdf', $cita) }}">
                                    PDF
                                </a>

                                @if(auth()->user()->role === 'admin')
                                    <a class="btn small" href="{{ route('citas.edit', $cita) }}">
                                        Editar
                                    </a>

                                    <form method="POST" action="{{ route('citas.destroy', $cita) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn danger small">
                                            Eliminar
                                        </button>
                                    </form>
                                @elseif(auth()->id() === $cita->user_id && $cita->estado === 'pendiente')
                                    <form method="POST" action="{{ route('citas.destroy', $cita) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn danger small">
                                            Cancelar solicitud
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </article>
</section>
@endsection