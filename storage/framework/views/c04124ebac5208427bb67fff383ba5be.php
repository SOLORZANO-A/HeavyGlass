<?php $__env->startSection('title', 'Vehicles'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-car"></i> Lista de Vehículos
                </h3>
            </div>

            <div class="row mb-3 align-items-center">

                <!-- Buscador -->
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Buscar por placa, marca o cliente..."
                            data-table-filter="vehicles-table">
                    </div>
                </div>

                <!-- Botón -->
                <div class="col-md-4 text-end">
                    <a href="<?php echo e(route('vehicles.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Nuevo Vehículo
                    </a>
                </div>

            </div>



            <div class="card-body table-responsive p-0">
                <table id="vehicles-table" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Vehiculo</th>
                            <th>Placa</th>
                            <th>Dueño</th>
                            <th>Año</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($vehicle->id); ?></td>
                                <td><?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?></td>
                                <td><?php echo e($vehicle->plate); ?></td>
                                <td><?php echo e($vehicle->client->fullName()); ?></td>
                                <td><?php echo e($vehicle->year ?? '—'); ?></td>
                                <td>
                                    <a href="<?php echo e(route('vehicles.show', $vehicle)); ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="<?php echo e(route('vehicles.edit', $vehicle)); ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="<?php echo e(route('vehicles.destroy', $vehicle)); ?>" method="POST"
                                        class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button type="button" class="btn btn-danger btn-sm" data-confirm
                                            data-title="¿Eliminar vehículo?"
                                            data-text="Se perderá el historial del vehículo" data-confirm="Sí, eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No se encontraron
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <?php echo e($vehicles->links()); ?>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/vehicles/index.blade.php ENDPATH**/ ?>