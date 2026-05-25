

<?php $__env->startSection('title', 'Inicio'); ?>

<?php $__env->startSection('content'); ?>
<section class="landing">
    <div>
        <p class="eyebrow">Sistema de gestion de citas</p>
        <h1>Agenda, especialistas y reportes en un solo panel.</h1>
        <p>Registra usuarios, administra especialistas, crea citas, consulta graficas y descarga reportes PDF.</p>
        <div class="actions">
            <a class="btn primary" href="<?php echo e(route('register')); ?>">Crear cuenta</a>
            <a class="btn" href="<?php echo e(route('login')); ?>">Iniciar sesion</a>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistema-citas\resources\views/auth/landing.blade.php ENDPATH**/ ?>