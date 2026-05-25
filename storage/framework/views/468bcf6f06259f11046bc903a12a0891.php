

<?php $__env->startSection('title', 'Citas'); ?>

<?php $__env->startSection('content'); ?>
<section class="grid-two">
    <article class="panel">
        <?php if(auth()->user()->role === 'admin'): ?>
            <h2>Gestionar solicitudes</h2>
            <p class="muted">
                Selecciona una cita pendiente en la tabla para asignar especialista, fecha, hora y estado.
            </p>
        <?php else: ?>
            <h2>Solicitar cita</h2>

            <form method="POST" action="<?php echo e(route('citas.store')); ?>" class="form">
                <?php echo csrf_field(); ?>

                <label>Motivo de la cita
                    <textarea name="motivo" required><?php echo e(old('motivo')); ?></textarea>
                </label>

                <button class="btn primary">Enviar solicitud</button>
            </form>
        <?php endif; ?>
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
                    <?php $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($cita->user->name); ?></td>

                            <td><?php echo e($cita->especialista?->nombre ?? 'Por asignar'); ?></td>

                            <td>
                                <?php echo e($cita->fecha ? $cita->fecha->format('Y-m-d') : 'Por asignar'); ?>

                            </td>

                            <td>
                                <?php echo e($cita->hora ? substr($cita->hora, 0, 5) : 'Por asignar'); ?>

                            </td>

                            <td>
                                <span class="badge"><?php echo e(ucfirst($cita->estado)); ?></span>
                            </td>

                            <td class="actions-cell">
                                <a class="btn small" href="<?php echo e(route('citas.pdf', $cita)); ?>">
                                    PDF
                                </a>

                                <?php if(auth()->user()->role === 'admin'): ?>
                                    <a class="btn small" href="<?php echo e(route('citas.edit', $cita)); ?>">
                                        Editar
                                    </a>

                                    <form method="POST" action="<?php echo e(route('citas.destroy', $cita)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button class="btn danger small">
                                            Eliminar
                                        </button>
                                    </form>
                                <?php elseif(auth()->id() === $cita->user_id && $cita->estado === 'pendiente'): ?>
                                    <form method="POST" action="<?php echo e(route('citas.destroy', $cita)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button class="btn danger small">
                                            Cancelar solicitud
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </article>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistema-citas\resources\views/citas/index.blade.php ENDPATH**/ ?>