<?php $__env->startSection('title', 'Proformas'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-invoice"></i> Proformas
                </h3>
            </div>

            <div class="row mb-3 align-items-center">

                <!-- Buscador -->
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Buscar por número, cliente o vehículo..."
                            data-table-filter="proformas-table">
                    </div>
                </div>

                <!-- Botón -->
                <div class="col-md-4 text-end">
                    <a href="<?php echo e(route('proformas.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Nueva Proforma
                    </a>
                </div>

            </div>


            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Vehiculo</th>
                            <th>Total</th>
                            <th>Firma</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th width="180">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $proformas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proforma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($proforma->id); ?></td>

                                <td><?php echo e($proforma->client_name); ?></td>

                                <td>
                                    <?php echo e($proforma->vehicle_brand); ?> <?php echo e($proforma->vehicle_model); ?>

                                    <br>
                                    <small class="text-muted"><?php echo e($proforma->vehicle_plate); ?></small>
                                </td>

                                <td>
                                    $<?php echo e(number_format($proforma->total, 2)); ?>

                                </td>
                                <td>
                                    <?php if($proforma->isSigned()): ?>
                                        <span class="badge badge-success">
                                            <i class="fas fa-pen"></i> Firmada
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            <?php echo e($proforma->signed_at?->format('Y-m-d')); ?>

                                        </small>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-pen-slash"></i> No firmada
                                        </span>
                                    <?php endif; ?>
                                </td>



                                
                                <td>
                                    <?php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'partial' => 'info',
                                            'paid' => 'success',
                                            'approved' => 'success',
                                            'cancelled' => 'danger',
                                        ];
                                    ?>

                                    <span class="badge badge-<?php echo e($statusColors[$proforma->status] ?? 'secondary'); ?>">
                                        <?php echo e(ucfirst($proforma->status)); ?>

                                    </span>
                                </td>

                                <td><?php echo e($proforma->created_at->format('Y-m-d')); ?></td>

                                <td>
                                    
                                    <a href="<?php echo e(route('proformas.show', $proforma)); ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    
                                    <?php if($proforma->status !== 'paid'): ?>
                                        <a href="<?php echo e(route('proformas.edit', $proforma)); ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php if($proforma->status !== 'paid'): ?>
                                        <a href="<?php echo e(route('payments.create', ['proforma_id' => $proforma->id])); ?>"
                                            class="btn btn-success btn-sm">
                                            <i class="fas fa-cash-register"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                                        <form action="<?php echo e(route('proformas.destroy', $proforma)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

                                            <button type="button" class="btn btn-danger btn-sm" data-confirm
                                                data-title="¿Eliminar proforma?" data-text="No se puede recuperar después"
                                                data-confirm="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No hay proformas
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <?php echo e($proformas->links()); ?>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/proformas/index.blade.php ENDPATH**/ ?>