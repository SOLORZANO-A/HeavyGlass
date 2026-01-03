

<?php $__env->startSection('title', 'Intake Sheets'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo e(session('error')); ?>

                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>


        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Vehículos – Hojas de Ingreso</h3>

                <div class="card-tools">
                    <a href="<?php echo e(route('intake_sheets.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Hoja de Ingreso
                    </a>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Placa</th>
                            <th>Ingreso</th>
                            <th>Combustible</th>
                            <th>KM</th>
                            <th>Condición</th>
                            <th>Fotos</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $intakeSheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sheet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($sheet->id); ?></td>

                                
                                <td>
                                    <?php echo e($sheet->vehicle?->client?->fullName() ?? '—'); ?>

                                </td>

                                
                                <td>
                                    <?php echo e($sheet->vehicle?->brand ?? ''); ?>

                                    <?php echo e($sheet->vehicle?->model ?? ''); ?>

                                </td>

                                
                                <td><?php echo e($sheet->vehicle?->plate ?? '—'); ?></td>

                                
                                <td>
                                    <?php echo e($sheet->entry_at ? $sheet->entry_at->format('Y-m-d H:i') : '—'); ?>

                                </td>

                                
                                <td><?php echo e($sheet->fuel_level ?? '—'); ?></td>

                                
                                <td><?php echo e($sheet->km_at_entry ?? '—'); ?></td>

                                
                                <td>
                                    <?php if($sheet->has_dents): ?>
                                        <span class="badge badge-warning">Aboll.</span>
                                    <?php endif; ?>
                                    <?php if($sheet->has_scratches): ?>
                                        <span class="badge badge-info">Ray.</span>
                                    <?php endif; ?>
                                    <?php if($sheet->has_cracks): ?>
                                        <span class="badge badge-danger">Grietas</span>
                                    <?php endif; ?>
                                    <?php if(!$sheet->has_dents && !$sheet->has_scratches && !$sheet->has_cracks): ?>
                                        <span class="text-muted">OK</span>
                                    <?php endif; ?>
                                </td>

                                
                                <td class="text-center">
                                    <?php if($sheet->photos && $sheet->photos->count()): ?>
                                        <span class="badge badge-success">
                                            <?php echo e($sheet->photos->count()); ?> 📷
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                
                                <td>
                                    <a href="<?php echo e(route('intake_sheets.show', $sheet)); ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="<?php echo e(route('intake_sheets.edit', $sheet)); ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="<?php echo e(route('intake_sheets.destroy', $sheet)); ?>" method="POST"
                                        class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button type="button" class="btn btn-danger btn-sm" data-confirm
                                            data-title="¿Eliminar hoja de ingreso?" data-text="La hoja de ingresoserá eliminado definitivamente"
                                            data-confirm="Sí, eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted">
                                    No se encontraron hojas de ingreso
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <?php echo e($intakeSheets->links()); ?>

            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/intake_sheets/index.blade.php ENDPATH**/ ?>