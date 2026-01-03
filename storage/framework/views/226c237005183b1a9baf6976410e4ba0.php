

<?php $__env->startSection('title', 'Vehicle Details'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Información Vehiculo</h3>

                <div class="card-tools">
                    <a href="<?php echo e(route('vehicles.edit', $vehicle)); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>

                    <a href="<?php echo e(route('vehicles.index')); ?>" class="btn btn-secondary btn-sm">
                        Atras
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Dueño / Clientes</th>
                        <td><?php echo e($vehicle->client->fullName()); ?></td>
                    </tr>
                    <tr>
                        <th>MArca</th>
                        <td><?php echo e($vehicle->brand); ?></td>
                    </tr>
                    <tr>
                        <th>Modelo</th>
                        <td><?php echo e($vehicle->model); ?></td>
                    </tr>
                    <tr>
                        <th>Placa</th>
                        <td><?php echo e($vehicle->plate); ?></td>
                    </tr>
                    <tr>
                        <th>Año</th>
                        <td><?php echo e($vehicle->year ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Color</th>
                        <td><?php echo e($vehicle->color ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Descripción</th>
                        <td><?php echo e($vehicle->description ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Hora de creacion</th>
                        <td><?php echo e($vehicle->created_at->format('Y-m-d H:i')); ?></td>
                    </tr>
                </table>
            </div>

            <div class="card-footer">
                <a href="<?php echo e(route('vehicles.index')); ?>" class="btn btn-secondary">
                    Regresar a la lista
                </a>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/vehicles/show.blade.php ENDPATH**/ ?>