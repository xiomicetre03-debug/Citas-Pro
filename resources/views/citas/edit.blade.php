@extends('layouts.app')

@section('title', 'Asignar cita')

@section('content')
<section class="panel narrow">
    <h2>Asignar cita</h2>

    <p class="muted">
        Solicitud de {{ $cita->user->name }}
    </p>

    <form method="POST" action="{{ route('citas.update', $cita) }}" class="form">
        @csrf
        @method('PUT')

        <label>Especialista
            <select name="especialista_id" required>
                <option value="">Seleccionar especialista</option>

                @foreach($especialistas as $especialista)
                    <option
                        value="{{ $especialista->id }}"
                        @selected(old('especialista_id', $cita->especialista_id) == $especialista->id)
                    >
                        {{ $especialista->nombre }} - {{ $especialista->especialidad }}
                    </option>
                @endforeach
            </select>
        </label>

        <label>Fecha
            <input
                type="date"
                name="fecha"
                value="{{ old('fecha', $cita->fecha?->format('Y-m-d')) }}"
                required
            >
        </label>

        <label>Hora
            <input
                type="time"
                name="hora"
                value="{{ old('hora', $cita->hora ? substr($cita->hora, 0, 5) : '') }}"
                required
            >
        </label>

        <label>Motivo
            <textarea name="motivo" required>{{ old('motivo', $cita->motivo) }}</textarea>
        </label>

        <label>Estado
            <select name="estado" required>
                @foreach(['pendiente', 'confirmada', 'cancelada', 'finalizada'] as $estado)
                    <option
                        value="{{ $estado }}"
                        @selected(old('estado', $cita->estado) === $estado)
                    >
                        {{ ucfirst($estado) }}
                    </option>
                @endforeach
            </select>
        </label>

        <div class="actions-left">
            <button class="btn primary">Actualizar cita</button>
            <a class="btn" href="{{ route('citas.index') }}">Volver</a>
        </div>
    </form>
</section>
@endsection