

<?php $__env->startSection('title', 'Reporte de Proformas'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <h3 class="mb-4">Reporte de Proformas e Ingresos</h3>

        <form method="GET" action="<?php echo e(route('reports.proformas')); ?>" class="mb-4">
            <div class="row align-items-end">

                <div class="col-md-3">
                    <label>Desde</label>
                    <input type="date" name="from" class="form-control" value="<?php echo e(request('from')); ?>">
                </div>

                <div class="col-md-3">
                    <label>Hasta</label>
                    <input type="date" name="to" class="form-control" value="<?php echo e(request('to')); ?>">
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>

                    <a href="<?php echo e(route('reports.proformas')); ?>" class="btn btn-secondary">
                        Limpiar
                    </a>
                </div>

            </div>
        </form>

      
            <a href="<?php echo e(route('reports.proformas.pdf', request()->query())); ?>" class="btn btn-danger mb-3">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </a>
    


        <div class="row">

            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Total Proformas</h6>
                        <h3><?php echo e($totalProformas); ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center border-success">
                    <div class="card-body">
                        <h6>Proformas Firmadas</h6>
                        <h3 class="text-success"><?php echo e($firmadas); ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center border-warning">
                    <div class="card-body">
                        <h6>No Firmadas</h6>
                        <h3 class="text-warning"><?php echo e($noFirmadas); ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center border-primary">
                    <div class="card-body">
                        <h6>Ingresos Confirmados</h6>
                        <h3 class="text-primary">
                            $<?php echo e(number_format($ingresos, 2)); ?>

                        </h3>
                    </div>
                </div>
            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/reports/proformas.blade.php ENDPATH**/ ?>