<?php $__env->startSection('title', 'Work Orders'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Órdenes de taller</h3>

                <a href="<?php echo e(route('work_orders.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nueva orden de trabajo
                </a>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Vehículo</th>
                            <th>Tipo de trabajo</th>
                            <th>Técnicos</th>
                            <th>Estado</th>
                            <th>Fecha asignación</th>
                            <th>Fecha inicio</th>
                            <th>Fecha finalización</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $workOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                
                                <td>#<?php echo e($order->id); ?></td>

                                
                                <td>
                                    <?php echo e($order->intakeSheet->vehicle->brand); ?>

                                    <?php echo e($order->intakeSheet->vehicle->model); ?>

                                    <br>
                                    <small class="text-muted">
                                        <?php echo e($order->intakeSheet->vehicle->plate); ?>

                                    </small>
                                </td>

                                
                                <td class="align-top">
                                    <ul class="list-unstyled mb-0">
                                        <?php $__currentLoopData = $order->workTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <span class="badge badge-secondary">
                                                    <?php echo e($type->name); ?>

                                                </span>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </td>


                                
                                <td class="align-top">
                                    <?php $__empty_2 = true; $__currentLoopData = $order->technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $technician): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <div class="mb-1">
                                            <span class="badge badge-info d-block text-left">
                                                <?php echo e($technician->fullName()); ?>

                                                <?php if($technician->specialization): ?>
                                                    <small class="text-light">
                                                        (<?php echo e($technician->specialization); ?>)
                                                    </small>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span class="text-muted">Sin técnico asignado</span>
                                    <?php endif; ?>
                                </td>


                                
                                <?php
                                    $statusColors = [
                                        'pending' => 'secondary',
                                        'in_progress' => 'warning',
                                        'paused' => 'info',
                                        'completed' => 'success',
                                    ];
                                ?>
                                <td>
                                    <span class="badge badge-<?php echo e($statusColors[$order->status] ?? 'secondary'); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

                                    </span>
                                </td>

                                
                                <td><?php echo e($order->assigned_at?->format('Y-m-d') ?? '—'); ?></td>
                                <td><?php echo e($order->started_at?->format('Y-m-d') ?? '—'); ?></td>
                                <td><?php echo e($order->finished_at?->format('Y-m-d') ?? '—'); ?></td>

                                
                                <td>
                                    <a href="<?php echo e(route('work_orders.show', $order)); ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="<?php echo e(route('work_orders.edit', $order)); ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                                        <form action="<?php echo e(route('work_orders.destroy', $order)); ?>" method="POST"
                                            class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

                                            <button type="button" class="btn btn-danger btn-sm" data-confirm
                                                data-title="¿Eliminar orden de trabajo?"
                                                data-text="La orden de trabajo será eliminada definitivamente"
                                                data-confirm="Sí, eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    No hay órdenes de trabajo
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <?php echo e($workOrders->links()); ?>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/work_orders/index.blade.php ENDPATH**/ ?>