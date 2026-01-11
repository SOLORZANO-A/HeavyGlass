<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <div class="text-center mb-5">
        <h1 class="fw-bold">HEAVY GLASS</h1>
        <p class="text-muted fs-5">
            Sistema de gestión administrativa y control de ingresos
        </p>
    </div>

    
    <div class="row justify-content-center">

        <div class="col-md-3">
            <div class="card shadow-sm text-center mb-4">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h5>Proformas</h5>
                    <p class="text-muted small">
                        Registro y control de proformas para servicios automotrices.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center mb-4">
                <div class="card-body">
                    <i class="fas fa-signature fa-2x text-success mb-3"></i>
                    <h5>Firma del Cliente</h5>
                    <p class="text-muted small">
                        Validación de aceptación mediante firma digital del cliente.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center mb-4">
                <div class="card-body">
                    <i class="fas fa-cash-register fa-2x text-warning mb-3"></i>
                    <h5>Pagos</h5>
                    <p class="text-muted small">
                        Registro de pagos parciales y completos con control de estados.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="row justify-content-center">

        <div class="col-md-3">
            <div class="card shadow-sm text-center mb-4">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-2x text-info mb-3"></i>
                    <h5>Reportes</h5>
                    <p class="text-muted small">
                        Análisis de ingresos y proformas firmadas por períodos.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center mb-4">
                <div class="card-body">
                    <i class="fas fa-users fa-2x text-secondary mb-3"></i>
                    <h5>Gestión</h5>
                    <p class="text-muted small">
                        Administración de clientes, vehículos y perfiles del sistema.
                    </p>
                </div>
            </div>
        </div>

    </div>

    
    <div class="text-center mt-5">
        <p class="text-muted">
            © <?php echo e(date('Y')); ?> HEAVY GLASS — Sistema interno de gestión
        </p>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/home.blade.php ENDPATH**/ ?>