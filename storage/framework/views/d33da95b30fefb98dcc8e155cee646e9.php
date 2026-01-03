

<?php $__env->startSection('title', 'Work Order Details'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Orden de Trabajo #<?php echo e($workOrder->id); ?></h3>
            </div>

            <div class="card-body">
                <div class="row">

                    
                    <div class="col-md-6">

                        <h5><strong>Vehiculo</strong></h5>
                        <p>
                            <?php echo e($workOrder->intakeSheet->vehicle->brand); ?>

                            <?php echo e($workOrder->intakeSheet->vehicle->model); ?>

                            <br>
                            <small class="text-muted">
                                <?php echo e($workOrder->intakeSheet->vehicle->plate); ?>

                            </small>
                        </p>

                        <hr>

                        <h5><strong>Tipo de trabajo</strong></h5>
                        <ul>
                            <?php $__currentLoopData = $workOrder->workTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($type->name); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                        <hr>

                        <h5><strong>Técnicos asignados</strong></h5>

                        <?php if($workOrder->technicians->count()): ?>
                            <ul class="list-unstyled">
                                <?php $__currentLoopData = $workOrder->technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $technician): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <span class="badge badge-info">
                                            <?php echo e($technician->first_name); ?> <?php echo e($technician->last_name); ?>

                                            <?php if($technician->specialization): ?>
                                                (<?php echo e($technician->specialization); ?>)
                                            <?php endif; ?>
                                        </span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">Sin técnicos asignados</p>
                        <?php endif; ?>


                    </div>

                    
                    <div class="col-md-6">

                        <div class="col-md-6">
                            <h5><strong>Estado</strong></h5>

                            <?php
                                $statusLabels = [
                                    'pending' => 'Pendiente',
                                    'in_progress' => 'En progreso',
                                    'paused' => 'Pausado',
                                    'completed' => 'Completado',
                                ];

                                $statusColors = [
                                    'pending' => 'secondary',
                                    'in_progress' => 'primary',
                                    'paused' => 'warning',
                                    'completed' => 'success',
                                ];
                            ?>

                            <span class="badge badge-<?php echo e($statusColors[$workOrder->status] ?? 'secondary'); ?>">
                                <?php echo e($statusLabels[$workOrder->status] ?? '—'); ?>

                            </span>
                        </div>


                        <hr>

                        <h5><strong>Fecha de asignación</strong></h5>
                        <p><?php echo e($workOrder->assigned_at?->format('Y-m-d H:i') ?? '—'); ?></p>

                        <h5><strong>Fecha de inicio </strong></h5>
                        <p><?php echo e($workOrder->started_at?->format('Y-m-d H:i') ?? '—'); ?></p>

                        <h5><strong>Fecha de Finalizacion</strong></h5>
                        <p><?php echo e($workOrder->finished_at?->format('Y-m-d H:i') ?? '—'); ?></p>

                        <hr>

                        <h5><strong>Descripcion</strong></h5>
                        <p><?php echo e($workOrder->description ?? '—'); ?></p>

                    </div>

                </div>
            </div>

            <div class="card-footer">
                <a href="<?php echo e(route('work_orders.index')); ?>" class="btn btn-secondary">
                    Atras
                </a>

                <a href="<?php echo e(route('work_orders.edit', $workOrder)); ?>" class="btn btn-warning">
                    Editar
                </a>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/work_orders/show.blade.php ENDPATH**/ ?>