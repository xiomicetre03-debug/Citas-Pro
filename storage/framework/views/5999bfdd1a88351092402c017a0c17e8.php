<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Sistema de Citas'); ?></title>
    <link rel="icon" href="img/cita.png" type="img/png">
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <script src="<?php echo e(asset('js/datatables.js')); ?>" defer></script>
</head>
<body>
    <?php if(auth()->guard()->guest()): ?>
    <a class="guest-home-btn" href="<?php echo e(route('landing')); ?>">Inicio</a>
<?php endif; ?>
    <?php if(auth()->guard()->check()): ?>
        <aside class="sidebar">
            <div class="brand">CitasPro</div>
            <nav>
                <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                 <?php if(auth()->user()->role === 'admin'): ?>
                    <a href="<?php echo e(route('especialistas.index')); ?>">Especialistas</a>
                    <a href="<?php echo e(route('usuarios.index')); ?>">Usuarios</a>
                <?php endif; ?>
                <a href="<?php echo e(route('citas.index')); ?>">Citas</a>
                <a href="<?php echo e(route('perfil.index')); ?>">Perfil</a>
                  <?php if(auth()->user()->role === 'admin'): ?>
                    <a href="<?php echo e(route('reporte.pdf')); ?>">Reportes PDF</a>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button>Logout</button>
                </form>
            </nav>
        </aside>
    <?php endif; ?>

    <main class="main <?php if(auth()->guard()->check()): ?> with-sidebar <?php endif; ?>">
        <?php if(auth()->guard()->check()): ?>
            <header class="topbar">
                <div>
                    <span class="muted">Bienvenido</span>
                    <h1><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h1>
                </div>
                <div class="user-chip">
                    <?php if(auth()->user()->photo): ?>
                        <img src="<?php echo e(asset('storage/' . auth()->user()->photo)); ?>" alt="">
                    <?php endif; ?>
                    <span><?php echo e(auth()->user()->name); ?></span>
                </div>
            </header>
        <?php endif; ?>

        <?php if(session('status')): ?>
            <div class="alert success"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert error"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>
</body>
</html><?php /**PATH C:\laragon\www\sistema-citas\resources\views/layouts/app.blade.php ENDPATH**/ ?>