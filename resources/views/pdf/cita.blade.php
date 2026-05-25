<h1>Informacion de la cita</h1>

<p><strong>Codigo de cita:</strong> {{ $cita->id }}</p>

<p><strong>Usuario:</strong> {{ $cita->user->name }}</p>

<p><strong>Correo:</strong> {{ $cita->user->email }}</p>

<p>
    <strong>Especialista:</strong>
    {{ $cita->especialista?->nombre ?? 'Por asignar' }}
</p>

<p>
    <strong>Especialidad:</strong>
    {{ $cita->especialista?->especialidad ?? 'Por asignar' }}
</p>

<p>
    <strong>Telefono especialista:</strong>
    {{ $cita->especialista?->telefono ?? 'Por asignar' }}
</p>

<p>
    <strong>Fecha:</strong>
    {{ $cita->fecha ? $cita->fecha->format('Y-m-d') : 'Por asignar' }}
</p>

<p>
    <strong>Hora:</strong>
    {{ $cita->hora ? substr($cita->hora, 0, 5) : 'Por asignar' }}
</p>

<p><strong>Estado:</strong> {{ ucfirst($cita->estado) }}</p>

<p><strong>Motivo:</strong> {{ $cita->motivo }}</p>

<p>
    <strong>Fecha de solicitud:</strong>
    {{ $cita->created_at?->format('Y-m-d H:i') }}
</p>

<p>
    <strong>Ultima actualizacion:</strong>
    {{ $cita->updated_at?->format('Y-m-d H:i') }}
</p>