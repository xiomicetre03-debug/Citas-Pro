@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@if(auth()->user()->role === 'admin')
    <section class="summary-grid">
        <article class="summary-card">
            <span>Total citas</span>
            <strong>{{ $citasPorMes->sum('total') }}</strong>
        </article>

        <article class="summary-card">
            <span>Especialistas activos</span>
            <strong>{{ $especialistasMasSolicitados->count() }}</strong>
        </article>

        <article class="summary-card">
            <span>Usuario activo</span>
            <strong>{{ auth()->user()->name }}</strong>
        </article>
    </section>

    <section class="stats-grid">
        <article class="panel chart-panel">
            <div class="panel-head">
                <div>
                    <h2>Citas por mes</h2>
                    <p class="muted">Citas asignadas por periodo</p>
                </div>
            </div>
            <canvas id="citasPorMes"></canvas>
        </article>

        <article class="panel chart-panel">
            <div class="panel-head">
                <div>
                    <h2>Especialistas mas solicitados</h2>
                    <p class="muted">Ranking segun citas asignadas</p>
                </div>
            </div>
            <canvas id="especialistas"></canvas>
        </article>
    </section>

    <script>
    const citasPorMes = @json($citasPorMes);
    const especialistas = @json($especialistasMasSolicitados);

    function drawBars(canvas, rows) {
        const ctx = canvas.getContext('2d');
        const width = canvas.width = canvas.offsetWidth;
        canvas.height = 300;

        ctx.clearRect(0, 0, width, 300);
        ctx.font = '14px Arial';

        if (!rows.length) {
            ctx.fillStyle = '#667085';
            ctx.fillText('Sin citas asignadas todavia.', 24, 48);
            return;
        }

        const max = Math.max(...rows.map(row => Number(row.total)), 1);
        const gap = 28;
        const left = 44;
        const bottom = 238;
        const barWidth = Math.max(46, (width - 100 - gap * rows.length) / rows.length);

        rows.forEach((row, index) => {
            const total = Number(row.total);
            const barHeight = (total / max) * 170;
            const x = left + index * (barWidth + gap);
            const y = bottom - barHeight;

            ctx.fillStyle = '#dbeafe';
            ctx.fillRect(x, 60, barWidth, 178);

            ctx.fillStyle = '#2563eb';
            ctx.fillRect(x, y, barWidth, barHeight);

            ctx.fillStyle = '#172033';
            ctx.font = '700 14px Arial';
            ctx.fillText(total, x + 8, y - 10);

            ctx.fillStyle = '#667085';
            ctx.font = '13px Arial';
            ctx.fillText(row.mes, x, 268);
        });
    }

    function drawList(canvas, rows) {
        const ctx = canvas.getContext('2d');
        const width = canvas.width = canvas.offsetWidth;
        canvas.height = 300;

        ctx.clearRect(0, 0, width, 300);
        ctx.font = '14px Arial';

        if (!rows.length) {
            ctx.fillStyle = '#667085';
            ctx.fillText('Sin especialistas registrados todavia.', 24, 48);
            return;
        }

        const max = Math.max(...rows.map(row => Number(row.total)), 1);

        rows.forEach((row, index) => {
            const y = 58 + index * 48;
            const value = Number(row.total);
            const barWidth = (value / max) * Math.max(100, width - 260);

            ctx.fillStyle = '#172033';
            ctx.font = '700 14px Arial';
            ctx.fillText(row.nombre, 24, y);

            ctx.fillStyle = '#dcfce7';
            ctx.fillRect(190, y - 18, width - 250, 22);

            ctx.fillStyle = '#16a34a';
            ctx.fillRect(190, y - 18, barWidth, 22);

            ctx.fillStyle = '#172033';
            ctx.fillText(value, 200 + barWidth, y);
        });
    }

    drawBars(document.getElementById('citasPorMes'), citasPorMes);
    drawList(document.getElementById('especialistas'), especialistas);
    </script>
@else
    <section class="panel">
        <h2>Mis citas</h2>

        <div class="table-wrap">
            <table data-datatable data-page-size="6">
                <thead>
                    <tr>
                        <th>Especialista</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Motivo</th>
                        <th>PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($misCitas as $cita)
                        <tr>
                            <td>{{ $cita->especialista?->nombre ?? 'Por asignar' }}</td>
                            <td>{{ $cita->fecha ? $cita->fecha->format('Y-m-d') : 'Por asignar' }}</td>
                            <td>{{ $cita->hora ? substr($cita->hora, 0, 5) : 'Por asignar' }}</td>
                            <td><span class="badge">{{ ucfirst($cita->estado) }}</span></td>
                            <td>{{ $cita->motivo }}</td>
                            <td>
                                <a class="btn small" href="{{ route('citas.pdf', $cita) }}">Descargar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($misCitas->isEmpty())
            <p class="muted">Todavia no has solicitado citas.</p>
        @endif
    </section>
@endif
@endsection