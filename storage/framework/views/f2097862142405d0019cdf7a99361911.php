<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'HEAVY GLASS'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
          rel="stylesheet"/>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <?php if(auth()->guard()->check()): ?>
                <li class="nav-item">
                    <span class="nav-link"><?php echo e(auth()->user()->name); ?></span>
                </li>

                <li class="nav-item">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-link nav-link">
                            <i class="fas fa-sign-out-alt"></i> Salir
                        </button>
                    </form>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="<?php echo e(route('dashboard')); ?>" class="brand-link">
            <span class="brand-text font-weight-light">HEAVY GLASS</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu">

                    <li class="nav-item">
                        <a href="<?php echo e(route('dashboard')); ?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage clients')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('clients.index')); ?>" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Clientes</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage vehicles')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('vehicles.index')); ?>" class="nav-link">
                                <i class="nav-icon fas fa-car"></i>
                                <p>Vehículos</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage intake sheets')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('intake_sheets.index')); ?>" class="nav-link">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Hojas de Ingreso</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage work types')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('work_types.index')); ?>" class="nav-link">
                                <i class="nav-icon fas fa-wrench"></i>
                                <p>Tipos de Trabajos</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage work orders')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('work_orders.index')); ?>" class="nav-link">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>Órdenes de Trabajo</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage proformas')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('proformas.index')); ?>" class="nav-link">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>Proformas</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('reports.proformas')); ?>" class="nav-link">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Reporte de Ingresos</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage payments')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('payments.index')); ?>" class="nav-link">
                                <i class="nav-icon fas fa-cash-register"></i>
                                <p>Pagos</p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage profiles')): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('profiles.index')); ?>" class="nav-link">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>Perfiles</p>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper p-3">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

</div>

<!-- ================== SCRIPTS ================== -->

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-2",
            cancelButton: "btn btn-danger mx-2"
        },
        buttonsStyling: false
    });

    document.querySelectorAll('[data-confirm]').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            swalWithBootstrapButtons.fire({
                title: this.dataset.title || '¿Estás seguro?',
                text: this.dataset.text || 'Esta acción no se puede deshacer',
                icon: this.dataset.icon || 'warning',
                showCancelButton: true,
                confirmButtonText: this.dataset.confirm || 'Sí, confirmar',
                cancelButtonText: this.dataset.cancel || 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

});
</script>

<?php if($errors->any()): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Acción no permitida',
    html: `<?php echo implode('<br>', $errors->all()); ?>`,
    confirmButtonText: 'Entendido'
});
</script> <?php endif; ?>

<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/layouts/app.blade.php ENDPATH**/ ?>